<?php

namespace Modules\Admin\Http\Controllers\Settings\Currencies;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\CurrencyService;
use Modules\Admin\DataView\Settings\Currency\Currency;
use Illuminate\Validation\Rule;
use Throwable;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(Currency::class)->process();
        return view('admin::settings.currencies.leads.index', compact('lists'));
    }

    public function create()
    {
        return view('admin::settings.currencies.leads.form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                'max:255',

                Rule::unique('currencies')->where(function ($query) use ($request) {
                    return $query->where('code', $request->code)
                        ->where('symbol', $request->symbol);
                })
            ],
            'name' => 'required|string|max:255',
            'symbol' => 'string|nullable',
            'decimal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = $this->currencyService->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'currency created successfully!',
                'redirect_url' => route('admin.settings.currencies.leads.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again. ' . $e
            ], 500);
        }
    }

    public function show($id)
    {
        $user = $this->currencyService->find($id);
        if (!$user) {
            return redirect()->route('admin.settings.currencies.leads.index')->with('error', 'User not found.');
        }
        // $roles = Role::all();
        return view('admin::settings.currencies.leads.form', compact('user'));
    }

    public function edit($id)
    {
        $currency = $this->currencyService->find($id);
        return view('admin::settings.currencies.leads.form', compact('currency'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                'max:255',

                Rule::unique('currencies')->where(function ($query) use ($request) {
                    return $query->where('code', $request->code)
                        ->where('symbol', $request->symbol);
                })
            ],
            'name' => 'required|string',
            'symbol' => 'required|string',
            'decimal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $currency = $this->currencyService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Currency updated successfully!',
                'redirect_url' => route('admin.settings.currencies.leads.index'),
                'data' => $currency
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $this->currencyService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted',
                'redirect_url' => route('admin.settings.currencies.leads.index'),
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
            'ids.*' => 'integer|exists:admins,id',
        ]);
        try {
            $deletedCount = $this->currencyService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.currencies.leads.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.currencies.leads.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
