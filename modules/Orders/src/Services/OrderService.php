<?php

namespace Modules\Orders\Services;

use Illuminate\Support\Str;
use Modules\Orders\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Catalog\Models\Product;
use Modules\Orders\Models\OrderItem;
use Modules\Tax\Services\TaxService;
use Modules\Orders\Enums\OrderStatus;
use Modules\Inventory\Models\Inventory;
use Illuminate\Support\Facades\Notification;
use Modules\Payments\Services\PaymentService;
use Modules\Notifications\Events\OrderCreated;
use Modules\Shipping\Services\ShippingService;
use Modules\Discounts\Services\DiscountService;
use Modules\Orders\Services\TransactionService;
use Modules\Notifications\Events\OrderStatusChanged;
use Modules\Notifications\Services\NotificationService;
use Modules\Notifications\Services\NotificationDispatcher;

class OrderService
{
    public function __construct(
        protected PaymentService $paymentService,
        protected TransactionService $transactionService,
        // protected ShippingService $shippingService,
        protected TaxService $taxService,
        protected DiscountService $discountService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Create a new order from checkout data
     * 
     * @param array $orderData
     * @return Order
     * @throws \Exception
     */
    public function createOrder(array $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            // Validate customer
            $user = $this->validateCustomer($orderData['user_id']);

            // Validate and prepare order data
            $preparedData = $this->prepareOrderData($orderData, $user);

            // Create the order
            $order = Order::create($preparedData['order']);

            // Process order items
            $this->processOrderItems($order, $preparedData['items']);

            // Handle inventory
            $this->updateInventory($preparedData['items']);

            // Process payment if required
            if ($orderData['requires_payment'] ?? true) {
                $this->processPayment($order, $orderData);
                $this->recordInitialTransaction($order);
            }

            // Record initial transaction

            // Trigger order created event
            $this->notificationService->trigger(
                'Orders',
                'OrderCreated',
                $order->user,
                $order
            );

            return $order->load('items', 'user');
        });
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Order $order, string $status): Order
    {
        $previousStatus = $order->status;

        $order->update(['status' => $status]);

        // Trigger status change event
        // event(new OrderStatusChanged($order, $previousStatus));

        return $order;
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Order $order, string $reason = null): Order
    {
        return DB::transaction(function () use ($order, $reason) {
            // Update order status
            $order = $this->updateOrderStatus($order, fn_get_setting('general.order.cancelled'));

            // Process refund if needed
            if ($order->payment_status === 'paid') {
                $this->processRefund($order);
            }

            // Restock inventory
            $this->restockItems($order);

            // Record transaction
            $this->transactionService->record(
                order: $order,
                type: 'order_cancelled',
                amount: $order->total,
                status: 'completed',
                notes: $reason ?? 'Order cancelled by customer'
            );

            return $order;
        });
    }

    protected function validateCustomer(int $userId): User
    {
        return User::findOrFail($userId);
    }

    protected function prepareOrderData(array $orderData, User $user): array
    {
        $subtotal = $this->calculateSubtotal($orderData['items']);
        $discounts = $this->calculateDiscounts($orderData);
        $shipping = $this->calculateShipping($orderData);
        $tax = $this->calculateTax($orderData, $user);

        return [
            'order' => [
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'status' => $orderData['status'] ?? fn_get_setting('general.order.create'),
                'subtotal' => $subtotal,
                'discount' => $discounts,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $subtotal - $discounts + $tax + $shipping,
                'billing_address' => $orderData['billing_address'] ?? null,
                'shipping_address' => $orderData['billing_address'] ?? null,
                'notes' => $orderData['notes'] ?? null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'currency' => $orderData['currency'] ?? fn_get_setting('general.currency'),
                'coupon_code' => $orderData['coupon_code'] ?? null,
            ],
            'items' => $this->validateItems($orderData['items'])
        ];
    }

    protected function processOrderItems(Order $order, array $items): void
    {
        foreach ($items as $item) {
            $orderItem = $order->items()->create([
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'sku' => $item['sku'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'tax_rate' => $item['tax_rate'] ?? 0,
                'options' => $item['options'] ?? [],
                'dimensions' => $item['dimensions'] ?? null,
                'is_digital' => $item['is_digital'] ?? false,
            ]);
        }
    }

    /**
     * Update an existing order with new data
     * 
     * @param Order $order The order to update
     * @param array $updateData Array of data to update
     * @param bool $updateItems Whether to update order items (default: false)
     * @return Order
     * @throws \Exception
     */
    public function updateOrder(Order $order, array $updateData, bool $updateItems = false): Order
    {
        return DB::transaction(function () use ($order, $updateData, $updateItems) {
            $previousStatus = $order->status;
            $previousTotal = $order->total;

            // Prepare the base order data to update
            $orderUpdates = [];

            // Handle status updates
            if (isset($updateData['status'])) {
                $orderUpdates['status'] = $updateData['status'];
            }

            // Handle address updates
            if (isset($updateData['billing_address'])) {
                $orderUpdates['billing_address'] = $updateData['billing_address'];
            }

            if (isset($updateData['shipping_address'])) {
                $orderUpdates['shipping_address'] = $updateData['shipping_address'];
            }

            // Handle notes update
            if (isset($updateData['notes'])) {
                $orderUpdates['notes'] = $updateData['notes'];
            }

            // Handle item updates if requested
            if ($updateItems && isset($updateData['items'])) {
                $this->handleItemUpdates($order, $updateData['items']);

                // Recalculate order totals if items changed
                $subtotal = $this->calculateSubtotal($updateData['items']);
                $discounts = $this->calculateDiscounts($updateData);
                $shipping = $this->calculateShipping($updateData);
                $tax = $this->calculateTax($updateData, $order->user);

                $orderUpdates = array_merge($orderUpdates, [
                    'subtotal' => $subtotal,
                    'discount' => $discounts,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $subtotal - $discounts + $tax + $shipping,
                ]);
            }

            // Update the order with prepared data
            $order->update($orderUpdates);

            // Handle status change events if status was updated
            if (isset($updateData['status']) && $previousStatus !== $updateData['status']) {
                // event(new OrderStatusChanged($order, $previousStatus));
            }

            // Record transaction if total amount changed
            if (isset($orderUpdates['total']) && $previousTotal != $orderUpdates['total']) {
                $this->transactionService->record(
                    order: $order,
                    type: 'order_updated',
                    amount: $order->total,
                    status: 'completed',
                    notes: 'Order updated with new items/prices'
                );
            }

            return $order->fresh()->load('items', 'user');
        });
    }

    /**
     * Handle updates to order items
     * 
     * @param Order $order
     * @param array $items
     */
    protected function handleItemUpdates(Order $order, array $items): void
    {
        $currentItems = $order->items->keyBy('product_id');
        $newItems = collect($items)->keyBy('product_id');

        // Items to remove
        $itemsToRemove = $currentItems->diffKeys($newItems);
        $this->removeItems($order, $itemsToRemove);

        // Items to add
        $itemsToAdd = $newItems->diffKeys($currentItems);
        $this->addItems($order, $itemsToAdd->all());

        // Items to update
        $itemsToUpdate = $newItems->intersectByKeys($currentItems)
            ->filter(function ($newItem, $productId) use ($currentItems) {
                $currentItem = $currentItems[$productId];
                return $newItem['quantity'] != $currentItem->quantity ||
                    $newItem['price'] != $currentItem->price;
            });

        $this->updateItems($order, $itemsToUpdate->all(), $currentItems);
    }

    /**
     * Remove items from an order
     * 
     * @param Order $order
     * @param Collection $items
     */
    protected function removeItems(Order $order, $items): void
    {
        foreach ($items as $item) {
            // Restock inventory
            if ($item->product->stock_quantity) {
                Product::where('product_id', $item->product_id)
                    ->increment('quantity', $item->quantity);
            }

            // Remove the item
            $item->delete();
        }
    }

    /**
     * Add new items to an order
     * 
     * @param Order $order
     * @param array $items
     */
    protected function addItems(Order $order, array $items): void
    {
        $validatedItems = $this->validateItems($items);
        $this->processOrderItems($order, $validatedItems);
        $this->updateInventory($validatedItems);
    }

    /**
     * Update existing items in an order
     * 
     * @param Order $order
     * @param array $items
     * @param Collection $currentItems
     */
    protected function updateItems(Order $order, array $items, $currentItems): void
    {
        foreach ($items as $itemData) {
            $item = $currentItems[$itemData['product_id']];
            $quantityDiff = $itemData['quantity'] - $item->quantity;

            // Update the item
            $item->update([
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
            ]);

            // Adjust inventory if needed
            if ($item->product->stock_quantity && $quantityDiff != 0) {
                $operation = $quantityDiff > 0 ? 'decrement' : 'increment';
                Product::where('product_id', $item->product_id)
                    ->$operation('quantity', abs($quantityDiff));
            }
        }
    }

    protected function updateInventory(array $items): void
    {
        foreach ($items as $item) {
            if ($item['manages_inventory'] ?? true) {
                Product::where('product_id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }
        }
    }

    protected function restockItems(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product->stock_quantity) {
                Product::where('product_id', $item->product_id)
                    ->increment('quantity', $item->quantity);
            }
        }
    }

    protected function processPayment(Order $order, array $orderData): void
    {
        $payment = $this->paymentService->process(
            $order,
            $orderData['payment_method']
        );

        $order->update([
            'status' => $payment->order_status,
            'payment_status' => $payment->status,
            'payment_method' => $orderData['payment_method'],
            'payment_id' => $payment->id,
        ]);
    }

    protected function processRefund(Order $order): void
    {
        $this->paymentService->refund(
            order: $order,
            amount: $order->total,
            reason: 'Order cancelled'
        );
    }

    protected function recordInitialTransaction(Order $order): void
    {
        $this->transactionService->record(
            order: $order,
            type: 'order_created',
            amount: $order->total,
            status: 'pending',
            notes: 'Order created'
        );
    }

    protected function generateOrderNumber(): string
    {
        $prefix = fn_get_setting('general.order.prefix');
        $suffix = fn_get_setting('general.order.suffix');
        $length = fn_get_setting('general.order.length');
        $auto_generate = fn_get_setting('general.order.auto_generate');
        $date = '';
        if($auto_generate === 'Y') {
            $date = date('Ymd');
        }
        do {
            $number = $prefix . $date .'-' . Str::upper(Str::random($length)) . $suffix;
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    protected function calculateSubtotal(array $items): float
    {
        return array_reduce($items, fn($carry, $item) =>
        $carry + ($item['price'] * $item['quantity']), 0);
    }

    protected function calculateDiscounts(array $orderData): float
    {
        if (isset($orderData['coupon_code'])) {
            return $this->discountService->applyCoupon(
                $orderData['coupon_code'],
                $this->calculateSubtotal($orderData['items'])
            );
        }

        return $orderData['discount'] ?? 0;
    }

    protected function calculateTax(array $orderData, User $user): float
    {
        return $this->taxService->calculate(
            items: $orderData['items'],
            shippingAddress: $orderData['shipping_address'],
            billingAddress: $orderData['billing_address'],
            customer: $user
        );
    }

    protected function calculateShipping(array $orderData): float
    {
        return 0;
        // return $this->shippingService->calculate(
        //     items: $orderData['items'],
        //     shippingAddress: $orderData['shipping_address']
        // );
    }

    protected function validateItems(array $items): array
    {
        $validated = [];

        foreach ($items as $item) {
            $product = Product::findOrFail($item['product_id']);

            // Validate stock
            if ($product->track_stock === 'Y' && $product->stock_quantity < $item['quantity']) {
                throw new \Exception("Insufficient stock for product {$product->name}");
            }

            // Validate price
            if ($product->price != $item['price']) {
                throw new \Exception("Price mismatch for product {$product->name}");
            }

            $validated[] = array_merge($item, [
                'name' => $product->name,
                'sku' => $product->sku,
                'manages_inventory' => $product->stock_quantity
            ]);
        }

        return $validated;
    }

    protected function generateDigitalAccess(OrderItem $item, User $user): void
    {
        // Generate license keys or download links
        $licenseKey = Str::uuid()->toString();

        $user->digitalProducts()->create([
            'order_item_id' => $item->id,
            'product_id' => $item->product_id,
            'license_key' => $licenseKey,
            'download_url' => route('digital.download', ['product' => $item->product_id]),
            'expires_at' => now()->addYears(1),
        ]);
    }
}
