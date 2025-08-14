<?php

namespace Modules\Admin\Http\Controllers\Settings\Countries;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Database\Seeders\CountrySeeder;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\CountryService;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\DataView\Settings\Country\Country;
use Illuminate\Validation\Rule; 
use Throwable;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(Country::class)->process();
        return view('admin::settings.countries.leads.index', compact('lists'));
    }

    public function create()
    {
        return view('admin::settings.countries.leads.form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                Rule::unique('countries')->where(function ($query) use ($request) {
                    return $query->where('code', $request->code)
                                 ->where('name', $request->name);
                })
            ],
            'name' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $country = $this->countryService->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Country created successfully!',
                'redirect_url' => route('admin.settings.countries.leads.index'),
                'data' => $country
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e
            ], 500);
        }
    }

    public function show($id)
    {
        $user = $this->countryService->find($id); // You should already have a method like this in your service
        if (!$user) {
            return redirect()->route('admin.settings.countries.leads.index')->with('error', 'User not found.');
        }

        return view('admin::settings.countries.leads.form');
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = $this->countryService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Counrty updated successfully!',
                'redirect_url' => route('admin.settings.countries.leads.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    public function edit($id)
    {
        $country = $this->countryService->find($id);
        return view('admin::settings.countries.leads.form', compact('country'));
    }
    public function destroy($id)
    {
        try {
            $this->countryService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Country deleted',
                'redirect_url' => route('admin.settings.countries.leads.index'),
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
            'ids.*' => 'integer|exists:country,id',
        ]);
        try {
            $deletedCount = $this->countryService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.countries.leads.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.countries.leads.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
