<?php

namespace Modules\Admin\Http\Controllers\Settings\States;

use Illuminate\Http\Request;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\CountryState as StateModel;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\StateService;
use Modules\Acl\Services\CountryService;

use Illuminate\Support\Facades\Validator;
use Modules\Admin\DataView\Settings\CountryState\CountryState;

class StateController extends Controller
{
    protected $stateService;
    protected $countryService;

    public function __construct(StateService $stateService, CountryService $countryService)
    {
        $this->stateService = $stateService;
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(CountryState::class)->process();
        return view('admin::settings.states.index', compact('lists'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin::settings.states.form', compact('countries'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'string|nullable',
            'default_name' => 'string|nullable',
            'country_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        } $state = StateModel::all();

        try {

            $state = $this->stateService->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'State created successfully!',
                'redirect_url' => route('admin.settings.states.index'),
                'data' => $state
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e
            ], 500);
        }
    }

    public function show($id)
    {
        $state = $this->stateService->find($id); // You should already have a method like this in your service
        if (!$state) {
            return redirect()->route('admin.settings.states.index')->with('error', 'User not found.');
        }
        return view('admin::settings.states.form', compact('state'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'code' => 'string|nullable',
            'default_name' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $state = $this->stateService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'State updated successfully!',
                'redirect_url' => route('admin.settings.states.index'),
                'data' => $state
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wUndefined variable $strong. Please try again.' . $e
            ], 500);
        }
    }

    public function edit($id)
    {
        $countries = Country::all();
        $state = $this->stateService->find($id);
        return view('admin::settings.states.form', compact('state', 'countries'));
    }
    public function destroy($id)
    {
        try {
            $this->stateService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'State deleted',
                'redirect_url' => route('admin.settings.states.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:country_states,id',
        ]);
        try {
            $deletedCount = $this->stateService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.states.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.states.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
