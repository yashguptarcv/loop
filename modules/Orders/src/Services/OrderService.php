<?php

namespace Modules\Orders\Services;

use Exception;
use Illuminate\Support\Str;
use Modules\Orders\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Catalog\Models\Product;
use Modules\Orders\Models\OrderItem;
use Modules\Tax\Services\TaxService;
use Modules\Orders\Enums\OrderStatus;
use Modules\Payments\Models\Payments;
use Modules\Inventory\Models\Inventory;
use Modules\Orders\Enums\TransactionStatus;
use Illuminate\Support\Facades\Notification;
use Modules\Payments\Services\PaymentService;
use Modules\Notifications\Events\OrderCreated;
use Modules\Payments\Services\PaymentsService;
use Modules\Shipping\Services\ShippingService;
use Modules\Discounts\Services\DiscountService;
use Modules\Orders\Services\TransactionService;
use Modules\Notifications\Events\OrderStatusChanged;
use Modules\Notifications\Services\NotificationService;
use Modules\Notifications\Services\NotificationDispatcher;

class OrderService
{
    public function __construct(
        protected PaymentsService $paymentService,
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
            $this->recordInitialTransaction($order);

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
                status: 'cancelled',
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
        $subtotal       = $this->calculateSubtotal($orderData['items']);
        $discountAmount = $this->calculateDiscounts($orderData, $orderData['coupon_code'] ?? '');
        $shipping       = $this->calculateShipping($orderData);
        $tax            = $this->calculateTax($orderData, $user);

        return [
            'order' => [
                'user_id' => $user->id,
                'admin_id' => auth('admin')->id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => $orderData['status'] ?? fn_get_setting('general.order.create'),
                'subtotal' => $subtotal,
                'discount' => $discountAmount,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $subtotal - $discountAmount + $tax + $shipping,
                'billing_address' => $orderData['billing_address'] ?? null,
                'shipping_address' => $orderData['shipping_address'] ?? null,
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

            // Apply base updates
            $order->update(array_intersect_key($updateData, array_flip([
                'status',
                'billing_address',
                'shipping_address',
                'notes',
                'coupon_code',
                'payment_method',
                'payment_status',
                'user_id'
            ])));

            // Update items if needed
            if ($updateItems && !empty($updateData['items'])) {
                $this->handleItemUpdates($order, $updateData['items']);
            }

            // Always recalc totals after update
            $order = $this->recalculateOrder($order, $updateData, $updateItems ? $updateData['items'] : null);

            // Fire status change event
            if (isset($updateData['status']) && $previousStatus !== $updateData['status']) {
                // event(new OrderStatusChanged($order, $previousStatus));
            }

            // Record transaction if total changed
            if ($previousTotal != $order['total']) {
                // Update existing transaction
                $this->transactionService->updateTransaction($order->pendingTransaction, [
                    'amount' => $order->total,
                    'notes'  => 'Order total updated with recalculated totals',
                    'status' => TransactionStatus::PENDING,
                ]);
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
        // Wrong code
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
                'options' => $itemData['options'] ?? [],
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
        $this->paymentService->charge(
            $orderData['payment_method'],
            $order
        );
    }

    protected function processRefund(Order $order): void
    {
        $this->paymentService->refund(
            $order,
            $order->total
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
        if ($auto_generate === 'Y') {
            $date = date('Ymd');
        }
        do {
            $number = $prefix . $date . '-' . Str::upper(Str::random($length)) . $suffix;
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    protected function calculateSubtotal(array $items): float
    {
        return array_reduce($items, fn($carry, $item) =>
        $carry + ($item['price'] * $item['quantity']), 0);
    }

    protected function calculateDiscounts(array $orderData, $coupon_code = null): float
    {
        if (!empty($orderData['coupon_code'])) {
            $result = $this->discountService->applyCoupon($orderData['coupon_code'], $orderData);
            if (!empty($result)) {
                return $result['discount_amount'] ?? 0.0;
            } else {
                $orderData['discount']   = 0;
                $orderData['coupon_code']   = '';
            }
        }

        return 0.0;
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
                'manages_inventory' => $product->stock_quantity,
                'tax_id' => $product->tax_id // Make sure this is passed
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


    public function recalculateOrder(Order $order, $updateOrder, array $items = null): Order
    {
        $items = $items ?? $updateOrder['items'];
        $user = $order->user;

        $subtotal = $this->calculateSubtotal($items);

        $discounts = $this->calculateDiscounts($updateOrder, $order->coupon_code);

        $shipping = $this->calculateShipping([
            'items' => $items,
            'shipping_address' => $order['shipping_address'],
        ]);

        $tax = $this->calculateTax([
            'items' => $items,
            'shipping_address' => $order['shipping_address'],
            'billing_address' => $order['billing_address'],
        ], $user);

        $order->update([
            'subtotal'          => $subtotal,
            'discount'          => $discounts,
            'shipping'          => $shipping,
            'tax'               => $tax,
            'total' => $subtotal - $discounts + $tax + $shipping,
        ]);

        return $order->fresh()->load('items', 'user');
    }

    public function getPaymentData($orderData)
    {
        try {
            if (!empty($orderData['order_id'])) {
                return [];
            }
            $payment = Payments::with('method')->where('order_id', $orderData['order_id'])->get();

            return $payment->toArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getOrder(int $orderId): array
    {
        $order = Order::with([
            'items.product',
            'user',
            'payments',
        ])->findOrFail($orderId);

        $customer = $order->user;

        $shippingAddress = $order->shipping_address ?? [];
        $billingAddress = $order->billing_address ?? [];

        $itemsData = [];
        $subtotal = 0;

        $groupedTaxes = []; // summary taxes by type

        foreach ($order->items as $item) {
            /** @var Product $product */
            $product = $item->product;
            $lineTotal = $item->price * $item->quantity;
            $subtotal += $lineTotal;

            // Get tax rates for this product
            $taxRates = $this->taxService->getProductTaxRates($product->tax_id ?? null, $billingAddress);

            $itemTaxSum = 0;
            foreach ($taxRates as $rate) {
                $taxAmount = $this->taxService->calculateRateTaxFromOrder($rate, $lineTotal);
                $itemTaxSum += $taxAmount;

                // group by tax name for summary
                if (!isset($groupedTaxes[$rate->name])) {
                    $groupedTaxes[$rate->name] = [
                        'name'   => $rate->name,
                        'rate'   => $rate->rate_value,
                        'amount' => 0,
                    ];
                }
                $groupedTaxes[$rate->name]['amount'] += $taxAmount;
            }

            $itemsData[] = [
                'id'            => $item->id,
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'sku'           => $product->sku ?? null,
                'price'         => $item->price,
                'quantity'      => $item->quantity,
                'line_total'    => $lineTotal,
                'tax'           => $itemTaxSum,
                'options'       => $item->options ?? []
            ];
        }

        $discount = $order->discount ?? 0;
        $shipping = $order->shipping ?? 0;
        $totalTax = collect($groupedTaxes)->sum('amount');
        $grandTotal = ($subtotal - $discount) + $shipping + $totalTax;

        return [
            'order_id'      => $order->id,
            'currency'      => $order->currency,
            'order_number'  => $order->order_number,
            'status'        => $order->status,
            'coupon_code'   => $order->coupon_code,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'ip_address'    => $order->ip_address,
            'order_items'   => $itemsData,
            'discount'      => $discount,
            'order_summary' => [
                'subtotal'  => $subtotal,
                'discount'  => $discount,
                'shipping'  => $shipping,
                'tax'       => $totalTax,
                'taxes'     => array_values($groupedTaxes), // breakdown for order summary
                'total'     => $grandTotal,
            ],
            'customer_details' => [
                'id'    => $customer->id,
                'name'  => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone ?? '',
            ],
            'billing_address' => $billingAddress,
            'shipping_address' => $shippingAddress,
            'payment_details' => $order->payments->first(),
            'order_note' => $order->notes,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'subtotal' => $order->subtotal,
            'shipping' => $order->shipping,
            'tax' => $totalTax,
            'total' => $grandTotal,
        ];
    }

    /**
     * Recalculate order data stored in session (array-based), with support for multiple taxes per item.
     *
     * @param array $orderData
     * @return array
     */
    public function recalculateSessionOrder(array $orderData): array
    {
        $items = $orderData['order_items'] ?? [];
        $subtotal = 0.0;
        $groupedTaxes = [];

        // Preload products used by items to avoid N+1
        $productIds = array_unique(array_filter(array_map(fn($i) => $i['product_id'] ?? null, $items)));
        $products = [];
        if (!empty($productIds)) {
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        }

        foreach ($items as $index => &$item) {
            $price = (float)($item['price'] ?? 0);
            $quantity = (int)($item['quantity'] ?? 0);
            $lineTotal = $price * $quantity;
            $subtotal += $lineTotal;

            // Compute multi-rate taxes for this item
            $itemTaxSum = 0.0;
            $product = $products[$item['product_id']] ?? null;

            // Use the same tax lookup as getOrder()
            $taxRates = $this->taxService->getProductTaxRates($product->tax_id ?? null, $orderData['billing_address'] ?? []);

            foreach ($taxRates as $rate) {
                // calculateRateTaxFromOrder should compute tax amount for this rate & line total
                $taxAmount = $this->taxService->calculateRateTaxFromOrder($rate, $lineTotal);
                $itemTaxSum += $taxAmount;

                $taxName = $rate->name ?? ('tax_' . ($rate->id ?? uniqid()));
                $rateValue = $rate->rate_value ?? ($rate->rate ?? 0);

                if (!isset($groupedTaxes[$taxName])) {
                    $groupedTaxes[$taxName] = [
                        'name'   => $taxName,
                        'rate'   => $rateValue,
                        'amount' => 0.0,
                    ];
                }
                $groupedTaxes[$taxName]['amount'] += $taxAmount;
            }

            // Update item fields in session representation
            $orderData['order_items'][$index]['line_total'] = $lineTotal;
            $orderData['order_items'][$index]['tax'] = $itemTaxSum;
        }

        // Discount (uses existing calculateDiscounts helper)
        $discount = $this->calculateDiscounts($orderData, $orderData['coupon_code'] ?? null);

        // Shipping (calculateShipping expects 'items' key; pass order_items)
        $shipping = $this->calculateShipping([
            'items'            => $orderData['order_items'] ?? [],
            'shipping_address' => $orderData['shipping_address'] ?? [],
        ]);

        $paymentDetail = $this->getPaymentData($orderData);

        // Total tax (sum of grouped tax amounts)
        $totalTax = array_reduce($groupedTaxes, fn($carry, $g) => $carry + ($g['amount'] ?? 0), 0.0);

        // Final total
        $total = ($subtotal - $discount) + $shipping + $totalTax;

        $orderData['order_id']      = $orderData['order_id'] ?? $this->generateOrderNumber();
        $orderData['currency']      = $orderData['currency'] ?? fn_get_setting('general.currency');
        $orderData['order_number']  = $orderData['order_number'] ?? $this->generateOrderNumber();
        $orderData['status']        = $orderData['status'] ?? fn_get_setting('general.order.create');
        $orderData['coupon_code']   = $orderData['coupon_code'] ?? '';
        $orderData['payment_method'] = $orderData['payment_method'] ?? '';
        $orderData['payment_status'] = $orderData['payment_status'] ?? '';
        $orderData['ip_address']    = $orderData['ip_address'] ?? '';
        $orderData['order_items']   = $orderData['order_items'] ?? [];
        $orderData['discount']      = $discount ?? 0;
        $orderData['customer_details'] = [
            'id'    => $orderData['customer_details']['id'] ?? '',
            'name'  => $orderData['customer_details']['name'] ?? '',
            'email' => $orderData['customer_details']['email'] ?? '',
            'phone' => $orderData['customer_details']['phone'] ?? '',
        ];
        $orderData['billing_address']   = $orderData['billing_address'] ?? [];
        $orderData['shipping_address']  = $orderData['shipping_address'] ?? [];
        $orderData['payment_details']   = $paymentDetail;
        $orderData['order_note'] = $orderData['notes'] ?? '';

        // Update order-level summary
        $orderData['order_summary'] = [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'tax'      => $totalTax,
            'taxes'    => array_values($groupedTaxes),
            'total'    => $total,
        ];

        // Keep convenient top-level fields in sync
        $orderData['subtotal'] = $subtotal;
        $orderData['discount'] = $discount;
        $orderData['shipping'] = $shipping;
        $orderData['tax'] = $totalTax;
        $orderData['total'] = $total;

        return $orderData;
    }
}
