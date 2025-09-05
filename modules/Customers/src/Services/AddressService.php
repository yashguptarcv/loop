<?php

namespace Modules\Customers\Services;

use Modules\Customers\Models\User;
use Modules\Customers\Models\Address;
use Modules\Customers\Http\Requests\StoreOrUpdateCustomerRequest;

class AddressService
{
    /**
     * Save billing & shipping addresses for a customer.
     */
    public function saveAddresses(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        $this->saveBilling($customer, $request);
        $this->saveShipping($customer, $request);
    }

    /**
     * Save or update billing address.
     */
    protected function saveBilling(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        Address::updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'billing'],
            [
                'address_1'  => $request->billing_address_1,
                'city'       => $request->billing_city,
                'state'      => $request->billing_state,
                'postcode'   => $request->billing_zip,
                'country'    => $request->billing_country,
                'phone'      => $customer->phone,
                'email'      => $customer->email,
                'is_default' => true,
            ]
        );
    }

    /**
     * Save or update shipping address.
     */
    protected function saveShipping(User $customer, StoreOrUpdateCustomerRequest $request): void
    {
        $shippingData = $request->boolean('sameAsBilling')
            ? [
                'address_1' => $request->billing_address_1,
                'city'      => $request->billing_city,
                'state'     => $request->billing_state,
                'postcode'  => $request->billing_zip,
                'country'   => $request->billing_country,
            ]
            : [
                'address_1' => $request->shipping_address_1,
                'city'      => $request->shipping_city,
                'state'     => $request->shipping_state,
                'postcode'  => $request->shipping_zip,
                'country'   => $request->shipping_country,
            ];

        Address::updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'shipping'],
            array_merge($shippingData, [
                'phone'      => $customer->phone,
                'name'       => $customer->name,
                'email'      => $customer->email,
                'is_default' => !$request->boolean('sameAsBilling'),
            ])
        );
    }
}
