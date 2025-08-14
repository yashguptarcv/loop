<?php

namespace Modules\Admin\Http\Controllers\Website\Coupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\CouponService;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\DataView\Website\Coupons\Coupons;
use Illuminate\Validation\Rule;
use Throwable;
use Auth;


class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lists = fn_datagrid(Coupons::class)->process();

        return view('admin::website.coupons.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::website.coupons.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'coupon_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons')->where(function ($query) use ($request) {

                    return $query->where('coupon_code', $request->coupon_code)
                        ->where('name', $request->name);
                })
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'coupon_per_user' => 'nullable|integer|',
            'coupon_used_count' => 'nullable|integer|',
            'coupon_type' => 'required|in:F,P',
            'coupon_value' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->coupon_type === 'F';
                }),
                'integer',
                'min:1',
                'max:100'
            ],
            'coupon_status' => 'required|string|max:255',
            'coupon_message' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],);
        }

        try {

            $adminId = auth('admin')->id();

            $data = array_merge($request->all(), ['admin_id' => $adminId]);


            $coupon = $this->couponService->create($data);


            return response()->json([
                'success' => true,
                'message' => 'Coupon created successfully!',
                'redirect_url' => route('admin.coupons.index'),
                'data' => $coupon
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
    public function show($id)
    {

        $coupons = $this->couponService->find($id);

        if (!$coupons) {
            return redirect()->route('admin.coupons.index')->with('error', 'User not found.');
        }
        return view('admin::website.coupons.form', compact('coupons'));
    }

    public function edit($id)
    {
        $coupons = $this->couponService->find($id);

        return view('admin::website.coupons.form', compact('coupons'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'coupon_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons')->where(function ($query) use ($request) {

                    return $query->where('coupon_code', $request->coupon_code)
                        ->where('name', $request->name);
                })
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'coupon_per_user' => 'nullable|integer|',
            'coupon_used_count' => 'nullable|integer|',
            'coupon_type' => 'required|in:F,P',
            'coupon_value' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->coupon_type === 'F';
                }),
                'integer',
                'min:1',
                'max:100'
            ],
            'coupon_status' => 'required|string|max:255',
            'coupon_message' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $coupons = $this->couponService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Coupon updated successfully!',
                'redirect_url' => route('admin.coupons.index'),
                'data' => $coupons
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
            $this->couponService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted',
                'redirect_url' => route('admin.coupons.index'),
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
            $deletedCount = $this->couponService->deleteMultiple($request->ids);
            return redirect()->route('admin.coupons.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.coupons.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
