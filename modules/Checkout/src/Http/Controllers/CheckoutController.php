<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Modules\Customers\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\Leads\Models\Application;
use Modules\Checkout\Http\Controllers;
use Modules\Leads\Services\LeadService;
use Modules\Orders\Services\OrderService;
use Modules\Checkout\Http\Requests\CheckoutRequest;
use Modules\Checkout\Http\Requests\ApplicationRequest;
use Google\Service\AndroidManagement\ApplicationReport;
use Modules\Cart\Services\CartService;
use Modules\Notifications\Services\NotificationService;

class CheckoutController extends Controller
{
    protected $orderService;
    protected $leadService;
    protected $notificationService;
    protected $cartService;

    public function __construct(
        OrderService $orderService,
        LeadService $leadService,
        NotificationService $notificationService,
        CartService $cartService,
    ) {
        $this->orderService = $orderService;
        $this->leadService = $leadService;
        $this->notificationService = $notificationService;
        $this->cartService = $cartService;
    }


    public function application(Request $request)
    {
        try {
            $request->validate([
                'application_id' => [
                    'required',
                    Rule::exists('applications', 'id')->where(function ($query) {
                        $query->where('email', Auth::guard('customer')->user()->email);
                    }),
                ],
                'order_id' => [
                    'required',
                    Rule::exists('orders', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::guard('customer')->user()->id);
                    }),
                ],
            ]);


            $application = Application::where('id', $request->input('application_id'))->first();
            $order = $this->orderService->getOrder($application->order_id);
            session([
                'checkout.application' => $application->toArray(),
                'cart' => $order,
            ]);


            return view('shop::shop.form', ['checkout' => session('checkout', []), 'cart' => session('cart', [])]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            abort(404, 'No Application Exists');
        } catch (\Throwable $e) {
            abort(404, 'No Application Exists' . $e->getMessage());
        }
    }

    public function createApplication(ApplicationRequest $request)
    {
        try {
            $validate = $request->validated(); // returns validated data
            $product = fn_get_product_data(fn_get_setting('general.lead.product'));
            $application_price = $product->price;

            if (!empty($product->sale_price) && $product->sale_price > $product->price) {
                $application_price = $product->sale_price;
            }

            $application = [
                'name'  => $validate['full_name'],
                'email' => $validate['email'],
                'phone' => $validate['mobile'],
                'company'   => $validate['organization'],
                'source_id' => fn_get_setting('general.lead.source'),
                'value' => fn_convert_currency_rate($application_price * $validate['award_categories'], fn_get_setting('general.currency')),
                'description'   => '',
                'industries'    => '',
                'website'   => '',
                'address'   => '',
                'address_2' => '',
                'country'   => '',
                'state' => '',
                'city'  => '',
                'postal_code'   => '',
                'custom_fields' => json_encode(['alternate_contact' => $validate['alternate_contact'] ?? '', 'Industries' => $validate['award_category']]),
                'created_by'    => fn_get_setting('general.lead.default_user'),
            ];

            $lead = $this->leadService->create($application);

            $lead->notes()->create([
                'admin_id'  => fn_get_setting('general.lead.default_user'),
                'note'      => "Customer have queries " . auth('customer')->name,
                'created'   => now()
            ]);

            $this->notificationService->trigger(
                'Leads', //module name
                'CustomerNomination', // notification class name before Notification
                $validate,
                $lead
            );

            return redirect()->back()->with('success', 'Your Nomination has been submmited successfully, our team will connect with you shortly');
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function updateApplication(ApplicationRequest $request)
    {
        try {
            $validate = $request->validated(); // returns validated data

            if (!empty(session('checkout', []))) {
                $quantity = $validate['award_categories'];

                $application = session('checkout.application');

                $application['full_name']  = $validate['full_name'];
                $application['email']  = $validate['email'];
                $application['mobile']  = $validate['mobile'];
                $application['alternate_contact']  = $validate['alternate_contact'];
                $application['organization']  = $validate['organization'];
                $application['designation']  = $validate['designation'];


                session(['checkout.application' => $application]);

                $this->cartService->updateCurrency(session('cart'), session('currency'));
                $this->cartService->updateItemQuantity(fn_get_setting('general.lead.product'), (int)$quantity, session('cart'));

                $option = [];

                // Initialize award categories structure
                $option['award_categories'] = [
                    'name'   => 'Award Categories',
                    'categories' => [],
                ];

                foreach ($validate['award_category'] as $key => $category) {
                    $parent_id = $category['parent'];
                    $child_id  = $category['child'];

                    // Ensure parent is initialized
                    if (!isset($option['award_categories']['categories'][$parent_id])) {
                        $option['award_categories']['categories'][$parent_id] = [
                            'name'  => fn_get_category_path($parent_id),
                            'child' => [],
                        ];
                    }

                    // Handle child (normal vs "other")
                    if ($child_id && $child_id !== 'other') {
                        $option['award_categories']['categories'][$parent_id]['child'][$child_id] = fn_get_category_path($child_id);
                    } elseif ($child_id === 'other') {
                        $option['award_categories']['categories'][$parent_id]['child']["custom_{$key}"] = fn_get_category_path($parent_id) . ' / ' . $category['custom'];
                    }
                }
                
                $this->cartService->updateItemOptions(
                    fn_get_setting('general.lead.product'),
                    $option ?? [],
                    session('cart')
                );
                $sessionData = session('cart');
                $order = Order::findOrFail($sessionData['order_id']);

                $updateData = [
                    'order_id'          => $sessionData['order_id'],
                    'status'            => $sessionData['status'],
                    'total'             => $sessionData['total'],
                    'subtotal'          => $sessionData['subtotal'],
                    'items'             => $sessionData['order_items'],
                ];

                $updatedOrder = $this->orderService->updateOrder($order, $updateData, true);
                session(['redirect_back' => route('checkout.nomination')]);
                return redirect()->route('checkout.confirm');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            abort(404, $e->getMessage());
        }
    }

    public function confirm(Request $request)
    {
        if (!empty(session('cart', []))) {

            
            return view('checkout::checkout.checkout', ['order' => session('cart', [])]);
        } else {
            return redirect()->route('checkout.nomination');
        }
    }
}
