<?php

namespace Modules\Admin\Http\Controllers\Settings\Taxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\TaxService;
use Modules\Admin\DataView\Settings\Tax\Tax;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use Throwable;

class TaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(Tax::class)->process();
        return view('admin::settings.taxes.index', compact('lists'));
    }

    public function create()
    {
        return view('admin::settings.taxes.form');
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

            $tax = $this->taxService->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'tax created successfully!',
                'redirect_url' => route('admin.settings.countries.leads.index'),
                'data' => $tax
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $user = $this->taxService->find($id); // You should already have a method like this in your service
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
            $user = $this->taxService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Counrty updated successfully!',
                'redirect_url' => route('admin.settings.countries.leads.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }
    public function edit($id)
    {
        $tax = $this->taxService->find($id);
        return view('admin::settings.countries.leads.form', compact('tax'));
    }
    public function destroy($id)
    {
        try {
            $this->taxService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'tax deleted',
                'redirect_url' => route('admin.settings.countries.leads.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:tax,id',
        ]);
        try {
            $deletedCount = $this->taxService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.countries.leads.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.countries.leads.index')->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }
    }
}
