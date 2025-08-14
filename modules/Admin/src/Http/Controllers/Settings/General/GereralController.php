<?php

namespace Modules\Admin\Http\Controllers\Settings\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Admin\DataView\Settings\UsersGrid;
use Modules\Admin\DataView\Settings\Currency\Currency;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;

class GereralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leadStatus = fn_datagrid(LeadStatuses::class)->process();
        $currency = fn_datagrid(Currency::class)->process();
        $users = fn_datagrid(UsersGrid::class)->process();

        return view('admin::settings.general.index', compact('leadStatus', 'currency', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $settings = $request->input('settings');




        try {
            foreach ($settings as $key => $value) {
                fn_update_setting($key, $value);
            }

            return response()->json([
                'success' => true,
                'message' => 'settings created successfully!',
                'redirect_url' => route('admin.settings.general.leads.index'),
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
    public function show() {}

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
