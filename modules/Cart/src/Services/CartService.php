<?php

namespace Modules\Cart\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Catalog\Models\Product;
use Modules\Customers\Models\Address;
use Modules\Orders\Services\OrderService;
use Modules\Customers\Services\AddressService;
use Modules\Discounts\Services\DiscountService;
use Modules\Customers\Http\Requests\StoreOrUpdateCustomerRequest;

class CartService
{
    protected OrderService $orderService;
    protected DiscountService $discountService;
    protected AddressService $addressService;

    public function __construct(
        OrderService $orderService,
        DiscountService $discountService,
        AddressService $addressService
    ) {
        $this->orderService = $orderService;
        $this->discountService = $discountService;
        $this->addressService = $addressService;
    }

    /**
     * Get orderData from session.
     */
    public function getOrderData(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Save orderData to session.
     */
    public function saveOrderData(array $orderData): array
    {
        $orderData = $this->orderService->recalculateSessionOrder($orderData);
        session(['cart' => $orderData]);
        return $orderData;
    }

    /**
     * Update order status.
     */
    public function updateStatus(array $orderData, string $status): array
    {
        $orderData['status'] = $status;
        return $this->saveOrderData($orderData);
    }

    /**
     * Update order status.
     */
    public function updateCurrency(array $orderData, string $currency): array
    {
        $orderData['currency'] = $currency;
        return $this->saveOrderData($orderData);
    }

    /**
     * Attach customer to order.
     */
    public function setCustomer(User $customer, array $orderData): array
    {
        $orderData['customer_details'] = [
            'id'    => $customer->id,
            'name'  => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ];

        $customer->load(['defaultBillingAddress', 'defaultShippingAddress']);

        $orderData['billing_address'] = $this->formatAddress($customer->defaultBillingAddress, $customer);
        $orderData['shipping_address'] = $this->formatAddress($customer->defaultShippingAddress, $customer);

        return $this->saveOrderData($orderData);
    }

    /**
     * Apply discount coupon.
     */
    public function applyDiscount(string $coupon, array $orderData): array
    {
        if (! $this->discountService->validateCoupon($coupon, null, $orderData)) {
            throw new Exception("Invalid Coupon Code");
        }

        $orderData['coupon_code'] = $coupon;
        return $this->saveOrderData($orderData);
    }

    /**
     * Remove discount coupon.
     */
    public function removeDiscount(array $orderData): array
    {
        $orderData['coupon_code'] = null;
        $orderData['discount'] = 0;
        return $this->saveOrderData($orderData);
    }

    /**
     * Add products to cart.
     */
    public function addItems(array $productIds, array $orderData): array
    {
        $orderData['order_items'] = $orderData['order_items'] ?? [];

        foreach ($productIds as $productId) {
            $product = Product::findOrFail($productId);
            $this->validateApplicationProduct($orderData['order_items'], $product);

            $existing = collect($orderData['order_items'])
                ->firstWhere('product_id', $productId);

            if ($existing) {
                foreach ($orderData['order_items'] as &$item) {
                    if ($item['product_id'] === $productId) {
                        $item['quantity']++;
                        $item['line_total'] = $item['quantity'] * $item['price'];
                    }
                }
            } else {
                $orderData['order_items'][] = [
                    'id'           => $productId,
                    'product_id'   => $productId,
                    'product_name' => $product->name,
                    'sku'          => $product->sku,
                    'price'        => $product->price,
                    'quantity'     => 1,
                    'line_total'   => $product->price,
                    'tax'          => 0,
                ];
            }
        }

        return $this->saveOrderData($orderData);
    }

    /**
     * Update item options (example: size, color, custom fields).
     */
    public function updateItemOptions(int $itemId, array $options, array $orderData): array
    {
        foreach ($orderData['order_items'] as &$item) {
            if ($item['id'] == $itemId) {
                // Merge or replace options
                $item['options'] = $options ?? [];

                // Example: if options affect price
                if (isset($options['extra_price'])) {
                    $item['price'] = $item['price'] + (float) $options['extra_price'];
                }

                // Recalculate line total
                $item['line_total'] = $item['quantity'] * $item['price'];
            }
        }

        return $this->saveOrderData($orderData);
    }

    /**
     * Remove item by ID.
     */
    public function removeItem(int $itemId, array $orderData): array
    {
        $orderData['order_items'] = array_filter(
            $orderData['order_items'] ?? [],
            fn($item) => $item['id'] != $itemId
        );

        return $this->saveOrderData($orderData);
    }

    /**
     * Update item quantity.
     */
    public function updateItemQuantity(int $itemId, int $qty, array $orderData): array
    {
        foreach ($orderData['order_items'] as &$item) {
            if ($item['id'] == $itemId) {
                $item['quantity'] = $qty;
                $item['line_total'] = $qty * $item['price'];
            }
        }

        return $this->saveOrderData($orderData);
    }

    /***
     * Update existing customer details & addresses.
     */
    public function updateCustomer(User $customer, StoreOrUpdateCustomerRequest $request, array $orderData): array
    {
        DB::transaction(function () use ($request, $customer) {
            $this->saveCustomer($customer, $request);
        });

        return $this->setCustomer(
            $customer->fresh(['defaultBillingAddress', 'defaultShippingAddress']),
            $orderData
        );
    }

    /**
     * Update existing customer addresses and order addresses.
     */
    public function updateAddress(User $customer, $request, array $orderData): array
    {
        DB::transaction(function () use ($request, $customer, &$orderData) {
            // Save addresses for the customer
            // $this->addressService->saveAddresses($customer, $request);

            // Update billing address
            $billing_address = [
                'name'      => $request['name'] ?? $customer->name,
                'email'     => $request['email'] ?? $customer->email,
                'phone'     => $request['phone'] ?? $customer->phone,
                'address_1' => $request['address_1'],
                'address_2' => $request['address_2'] ?? null,
                'city'      => $request['city'],
                'state'     => $request['state'],
                'postcode'  => $request['postcode'],
                'country'   => $request['country'],
            ];

            $orderData['billing_address'] = $billing_address;
            $orderData['shipping_address'] = $billing_address;
        });

        return $this->saveOrderData($orderData);
    }

    /**
     * Save or update customer basic info.
     */
    protected function saveCustomer(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        $customer->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone ?? null,
        ]);
    }

    /**
     * Validation for application-only cart.
     */
    protected function validateApplicationProduct(array $orderItems, Product $newProduct): void
    {
        $hasApplication = collect($orderItems)->contains(
            fn($item) =>
            isset($item['product_id']) && $item['product_id'] === fn_get_setting('general.lead.product')
        );

        $isApplication = $newProduct->is_application ?? false;

        if ($hasApplication && ! $isApplication) {
            throw new Exception("You cannot add other products once an application product is in the order.");
        }

        if ($isApplication && ! empty($orderItems)) {
            throw new Exception("You cannot add an application product when other products already exist.");
        }
    }

    /**
     * Format customer address for order.
     */
    protected function formatAddress($address, User $customer): array
    {
        return [
            'name'      => $address->name ?? $customer->name,
            'email'     => $address->email ?? $customer->email,
            'phone'     => $address->phone ?? $customer->phone,
            'company'   => $address->company ?? '',
            'city'      => $address->city ?? '',
            'state'     => $address->state ?? '',
            'country'   => $address->country ?? '',
            'postcode'  => $address->postcode ?? '',
            'address_1' => $address->address_1 ?? '',
            'address_2' => $address->address_2 ?? '',
        ];
    }
}
