<?php

namespace Modules\Admin\Http\Controllers\Settings\Currencies;

use Throwable;
use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\CurrencyService;
use Modules\Admin\Models\CurrencyExchangeRate;
use Modules\Admin\DataView\Settings\Currency\Currency;

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
        return view('admin::settings.currencies.index', compact('lists'));
    }

    public function create()
    {
        $rates = CurrencyExchangeRate::all();
        return view('admin::settings.currencies.form', compact('rates'));
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
            'target_currency' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $currency = $this->currencyService->create($request->all());

            CurrencyExchangeRate::create([
                'target_currency' => $currency->id,
                'rate' => $request->input('target_currency'),

            ]);


            return response()->json([
                'success' => true,
                'message' => 'Currency created successfully!',
                'redirect_url' => route('admin.settings.currencies.index'),
                'data' => $currency
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again. ' . $e
            ]);
        }
    }

    public function show($id)
    {
        $currency = $this->currencyService->find($id);
        if (!$currency) {
            return redirect()->route('admin.settings.currencies.index')->with('error', 'User not found.');
        }
        return view('admin::settings.currencies.form', compact('user'));
    }

    public function edit($id)
    {
        $rate = CurrencyExchangeRate::where('target_currency', $id)->first();
        $currency = $this->currencyService->find($id);
        return view('admin::settings.currencies.form', compact('currency', 'rate'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'string',
                'max:255',

                Rule::unique('currencies')->where(function ($query) use ($request, $id) {
                    return $query->where('code', $request->code)->where('id', '!=', $id)
                        ->where('symbol', $request->symbol);
                })
            ],
            'name' => 'required|string',
            'symbol' => 'required|string',
            'decimal' => 'required',
            'target_currency' => 'required|numeric',
        ]);

        if ($validator->fails()) {  
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $currency = $this->currencyService->update($id, $request->all());
            CurrencyExchangeRate::updateOrCreate(
                ['target_currency' => $currency->id],
                ['rate' => $request->input('target_currency')]);

            return response()->json([
                'success' => true,
                'message' => 'Currency updated successfully!',
                'redirect_url' => route('admin.settings.currencies.index'),
                'data' => $currency
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'.$e->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            $this->currencyService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Currency deleted',
                'redirect_url' => route('admin.settings.currencies.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'.$e->getMessage()
            ]);
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
            return redirect()->route('admin.settings.currencies.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.currencies.index')->with('error', 'Something went wrong. Please try again.'. $e->getMessage());
        }
    }
}
