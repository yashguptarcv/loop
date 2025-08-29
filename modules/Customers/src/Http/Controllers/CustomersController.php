<?php

namespace Modules\Customers\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Customers\DataView\Customers;
use Modules\Customers\Models\User as ModelsUser;
use Modules\Customers\Models\Address;
use Modules\Customers\Http\Requests\StoreOrUpdateCustomerRequest;

class CustomersController extends Controller
{
    public function index()
    {
        $lists = fn_datagrid(Customers::class)->process();
        return view("customers::customers.index", compact('lists'));
    }

    public function show(ModelsUser $customer)
    {
        return view("customers::customers.profile.modal.form", compact('customer'));
    }

    public function edit(ModelsUser $customer = null)
    {
        return view("customers::customers.profile.modal.form", compact('customer'));
    }

    public function store(StoreOrUpdateCustomerRequest $request)
    {
        try {
            DB::transaction(function () use ($request, &$customer) {
                $customer = new ModelsUser();
                $this->saveCustomer($customer, $request);

                $this->saveAddresses($customer, $request);
            });

            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    public function update(StoreOrUpdateCustomerRequest $request, ModelsUser $customer)
    {
        try {
            DB::transaction(function () use ($request, $customer) {
                $this->saveCustomer($customer, $request);

                $this->saveAddresses($customer, $request);
            });

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save or update customer.
     */
    protected function saveCustomer(ModelsUser $customer, StoreOrUpdateCustomerRequest $request): void
    {
        $customer->name  = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone ?? null;

        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }

        $customer->save();
    }

    /**
     * Save billing & shipping addresses.
     */
    protected function saveAddresses(ModelsUser $customer, StoreOrUpdateCustomerRequest $request): void
    {
        // Billing
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

        // Shipping
        if ($request->boolean('sameAsBilling')) {
            $shippingData = [
                'address_1' => $request->billing_address_1,
                'city'      => $request->billing_city,
                'state'     => $request->billing_state,
                'postcode'  => $request->billing_zip,
                'country'   => $request->billing_country,
            ];
        } else {
            $shippingData = [
                'address_1' => $request->shipping_address_1,
                'city'      => $request->shipping_city,
                'state'     => $request->shipping_state,
                'postcode'  => $request->shipping_zip,
                'country'   => $request->shipping_country,
            ];
        }

        Address::updateOrCreate(
            ['user_id' => $customer->id, 'type' => 'shipping'],
            array_merge($shippingData, [
                'phone'      => $customer->phone,
                'name'       => $customer->name,
                'email'      => $customer->email,
                'is_default' => $request->boolean('sameAsBilling'),
            ])
        );
    }
}
