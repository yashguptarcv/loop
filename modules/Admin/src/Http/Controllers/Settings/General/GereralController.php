<?php

namespace Modules\Admin\Http\Controllers\Settings\General;

use DateTimeZone;
use Illuminate\Http\Request;
use Modules\Tax\DataView\Tax;
use App\Http\Controllers\Controller;
use Modules\Catalog\DataView\ProductGrid;
use Modules\Filemanager\Services\FileService;
use Modules\Admin\DataView\Settings\RolesGrid;
use Modules\Admin\DataView\Settings\UsersGrid;
use Modules\Admin\DataView\Settings\OrdersStatuses;
use Modules\Admin\DataView\Settings\Country\Country;
use Modules\Admin\DataView\Settings\Currency\Currency;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;

class GereralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $fileService;
    
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timezones = [];
        $now = new \DateTime();

        foreach (\DateTimeZone::listIdentifiers() as $tz) {
            $timezone = new \DateTimeZone($tz);
            $offset = $timezone->getOffset($now);
            $hours = intdiv($offset, 3600);
            $minutes = abs($offset % 3600) / 60;
            $formattedOffset = sprintf("UTC%+03d:%02d", $hours, $minutes);
            $timezones[$tz] = "($formattedOffset) $tz";
        }


        $currencies = fn_datagrid(Currency::class)->process();
        $users = fn_datagrid(UsersGrid::class)->process();
        $taxes = fn_datagrid(Tax::class)->process();
        $orderStatus = fn_datagrid(OrdersStatuses::class)->process();
        

        return view('admin::settings.general.index', compact(
            'currencies',
            'users',
            'timezones',
            'taxes',
            'orderStatus',
            
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $settings = $request->input('settings');

        try {
            if (!is_array($settings)) {
                throw new \Exception('Settings must be an array.');
            }
            foreach ($settings as $key => $value) {
                fn_update_setting($key, $value);
            }

             // Handle image upload
            if ($request->hasFile('company_logo')) {
                // Delete old image if exists
                $this->fileService->deleteFile('company_logo', 0);
                 // Handle image upload
                if ($request->hasFile('company_logo')) {
                        $fileLink = $this->fileService->uploadFile(
                        $request->file('company_logo'),
                        'company_logo',
                        0
                    );
                }
            }

            // Handle image upload
            if ($request->hasFile('company_favicon')) {
                // Delete old image if exists
                $this->fileService->deleteFile('company_favicon', 0);
                 // Handle image upload
                if ($request->hasFile('company_favicon')) {
                        $fileLink = $this->fileService->uploadFile(
                        $request->file('company_favicon'),
                        'company_favicon',
                        0
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'settings created successfully!',
                'redirect_url' => route('admin.settings.general.index'),
                'data' => $settings
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function create(Request $request)
    {
        $timezones = [];
        $now = new \DateTime();

        foreach (\DateTimeZone::listIdentifiers() as $tz) {
            $timezone = new \DateTimeZone($tz);
            $offset = $timezone->getOffset($now);
            $hours = intdiv($offset, 3600);
            $minutes = abs($offset % 3600) / 60;
            $formattedOffset = sprintf("UTC%+03d:%02d", $hours, $minutes);
            $timezones[$tz] = "($formattedOffset) $tz";
        }

        $countries = fn_datagrid(Country::class)->process();
        
        if ($request->input('tab')) {
            $tab = $request->input('tab');

            switch ($tab) {
                case 'general':
                    return view('admin::settings.general.general', compact(
                        'timezones'                       
                    ));
                case 'company':
                    return view('admin::settings.general.company', compact('countries'));
                case 'email':
                    return view('admin::settings.general.email');
                case 'channel':
                    return view('admin::settings.general.channel');
                case 'checkout':
                    return view('admin::settings.general.checkout');
                case 'lead':
                    return view('admin::settings.general.lead');
                case 'editortab':
                    return view('admin::settings.general.editortab');
                default:
                    abort(400);
            }
        }

        return view('admin::settings.general.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
