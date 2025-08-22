<?php

namespace Modules\Leads\Http\Controllers\Application;

use Illuminate\Http\Request;
use Modules\Acl\Models\Admin;
use Illuminate\Support\Carbon;
use Modules\Admin\Models\Country;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Leads\Models\LeadModel;
use Modules\Catalog\Models\Category;
use Modules\Meetings\Models\Meeting;
use Modules\Orders\Enums\OrderStatus;
use Modules\Leads\Models\AwardCategory;
use Illuminate\Support\Facades\Validator;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Orders\Services\OrderService;
use Modules\Leads\Models\LeadAttachmentModel;
use Modules\Leads\Services\ApplicationService;
use Modules\Leads\Http\Requests\ApplicationRequest;
use Modules\Meetings\Services\GoogleCalendarService;
use Modules\Notifications\Services\NotificationService;

class Application extends Controller
{
    protected $calendarService;
    protected $applicationService;
    protected $orderService;
    protected $notificationService;

    public function __construct(
        GoogleCalendarService $calendarService,
        ApplicationService $applicationService,
        OrderService $orderService,
        NotificationService $notificationService
    ) {
        $this->calendarService      = $calendarService;
        $this->applicationService   = $applicationService;
        $this->orderService         = $orderService;
        $this->notificationService  = $notificationService;

    }

    public function send_application(LeadModel $lead)
    {
        $countries          = Country::all();
        $mainCategories     = Category::whereNull('parent_id')->get();
        $subCategories      = Category::whereNotNull('parent_id')->get();
        $awardCategories    = AwardCategory::with(['country', 'mainCategory', 'subCategory'])->get();
        $application        = fn_get_product_data(fn_get_setting('general.lead.product'));

        return view('leads::leads.components.send-application',  compact(
            'countries',
            'mainCategories',
            'subCategories',
            'awardCategories',
            'lead',
            'application'
        ));
    }

    public function store(ApplicationRequest $request)
    {
        try {
            DB::beginTransaction();

            // 1. Create the application
            $application = $this->applicationService->createApplication(
                $request->validated(),
                $request->input('lead_id'),
                auth('admin')->id()
            );

            if ($application['success']) {

                // Trigger order created event
                $this->notificationService->trigger(
                    'Leads',
                    'Application',
                    $application['user'],
                    [
                        'password'      => $application['password'],
                        'application'   => $application['data']
                    ]
                );

                $orderData = $this->prepareOrderData($application['data'], $request, $application['user']);
            
                
                $order = $this->orderService->createOrder($orderData);

                
                if (isset($application['data']->id)) {                    
                    $application['data']->update(['order_id' => $order->id]);
                }

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Application submitted and order created successfully',
                    'redirect_url' => route('admin.orders.show', $order->id)
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'errors' => $application['response'] ?? 'Unknown error',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'errors' => 'Failed to process application: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Prepare order data from application
     */
    protected function prepareOrderData($application, Request $request, $user): array
    {
        // Get the application product
        $applicationProduct = fn_get_product_data(fn_get_setting('general.lead.product'));
        // Prepare order items array
        $items = [
            [
                'product_id' => $applicationProduct->id,
                'price' => $applicationProduct->price,
                'quantity' => 1,
                'name' => $applicationProduct->name,
                'sku' => $applicationProduct->sku,
                // Add any other necessary item fields
            ]
        ];

        // Get lead information for billing/shipping addresses if needed
        $lead = LeadModel::find($request->input('lead_id'));

        return [
            'user_id' => $user->id ?? null, // Or use a default system user if needed
            'items' => $items,
            'status' => fn_get_setting('general.order.create'),
            'billing_address' => [
                'name' => $lead->name ?? 'N/A',
                'email' => $lead->email ?? 'N/A',
                'phone' => $lead->phone ?? 'N/A',
                'country'   => '',
                'state'     => '',
                'city'      => '',
                'postcode'   => '',
                'address_1'     => '',
                // Add other address fields as needed
            ],
            'shipping_address' => [
                'name' => $lead->name ?? 'N/A',
                'email' => $lead->email ?? 'N/A',
                'phone' => $lead->phone ?? 'N/A',
                'country'   => '',
                'state'     => '',
                'city'      => '',
                'postcode'   => '',
                'address_1'     => '',
                // Same as billing or customize as needed
            ],
            'notes' => 'Application submission for lead #' . $lead->id,
            'requires_payment' => false, // Set based on your business logic
            'currency' => fn_get_setting('general.currency'),
            // Add any other necessary order fields
        ];
    }
}
