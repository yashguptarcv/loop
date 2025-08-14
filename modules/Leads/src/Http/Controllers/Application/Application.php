<?php

namespace Modules\Leads\Http\Controllers\Application;

use Illuminate\Http\Request;
use Modules\Acl\Models\Admin;
use Illuminate\Support\Carbon;
use Modules\Admin\Models\Country;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\LeadModel;
use Modules\Catalog\Models\Category;
use Modules\Meetings\Models\Meeting;
use Modules\Leads\Models\AwardCategory;
use Illuminate\Support\Facades\Validator;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Leads\Models\LeadAttachmentModel;
use Modules\Leads\Services\ApplicationService;
use Modules\Leads\Http\Requests\ApplicationRequest;
use Modules\Meetings\Services\GoogleCalendarService;

class Application extends Controller
{
    protected $calendarService;
    protected $applicationService;

    public function __construct(GoogleCalendarService $calendarService, ApplicationService $applicationService)
    {
        $this->calendarService      = $calendarService;
        $this->applicationService   = $applicationService;
    }

    public function send_application(LeadModel $lead)
    {
        $countries          = Country::all();
        $mainCategories     = Category::whereNull('parent_id')->get();
        $subCategories      = Category::whereNotNull('parent_id')->get();
        $awardCategories    = AwardCategory::with(['country', 'mainCategory', 'subCategory'])->get();
        $application        = fn_get_product_data(fn_get_setting('general.settings.default_application_product'));

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
            $application = $this->applicationService->createApplication(
                $request->validated(),
                $request->input('lead_id'),
                auth('admin')->id() // or whatever identifies your admin
            );

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully',
                'data' => $application
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
