<?php

namespace Modules\Discounts\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Discounts\Models\Coupon;
use Modules\Discounts\Models\Discount;
use Modules\Discounts\DataView\Discounts;
use Modules\Discounts\Services\DiscountService;
use Modules\Discounts\Http\Requests\StoreCouponRequest;
use Modules\Discounts\Http\Requests\UpdateCouponRequest;
use Modules\Discounts\Http\Requests\StoreDiscountRequest;
use Modules\Discounts\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Display a listing of discount.
     */
    public function index(Request $request)
    {
        $lists = fn_datagrid(Discounts::class)->process();
        return view('discounts::discount.index', compact('lists'));
    }

    /**
     * Show the form for creating a new discount.
     */
    public function create()
    {
        return view('discounts::discount.form');
    }

    /**
     * Store a newly created discount with coupons and rules from single form.
     */
    public function store(StoreDiscountRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the discount with all related data
            $discount = $this->discountService->createDiscount([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'amount' => $request->amount,
                'apply_to' => $request->apply_to,
                'is_active' => $request->boolean('is_active'),
                'starts_at' => $request->starts_at,
                'expires_at' => $request->expires_at,
                'user_groups' => $request->user_groups,
                'coupons' => $request->coupons,
                'rules' => $request->rules
            ]);
            
            // Update or create coupons
            if ($request->has('coupons')) {
                $this->handleCouponsUpdate($discount, $request->coupons);
            }

            // Update rules
            if ($request->has('rules')) {
                $this->discountService->saveDiscountRules($discount, $request->rules);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Discount created successfully!',
                'redirect_url' => route('admin.discount.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified discount with its coupons and rules.
     */
    public function show(Discount $discount)
    {
        $discount->load(['coupons', 'rules']);
        return view('discounts::discount.form', compact('discount'));
    }

    /**
     * Show the form for editing the specified discount.
     */
    public function edit(Discount $discount)
    {
        $discount->load(['coupons', 'rules']);
        return view('discounts::discount.form', compact('discount'));
    }

    /**
     * Update the specified discount with its rules and coupons.
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        try {
            DB::beginTransaction();

            // Update discount basic info
            $discount->update([
                'name' => $request->name ?? $discount->name,
                'description' => $request->description ?? $discount->description,
                'type' => $request->type ?? $discount->type,
                'amount' => $request->amount ?? $discount->amount,
                'apply_to' => $request->apply_to ?? $discount->apply_to,
                'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $discount->is_active,
                'starts_at' => $request->starts_at ?? $discount->starts_at,
                'expires_at' => $request->expires_at ?? $discount->expires_at,
                'user_groups' => $request->user_groups ?? $discount->user_groups,
            ]);

            // Update or create coupons
            if ($request->has('coupons')) {
                $this->handleCouponsUpdate($discount, $request->coupons);
            }

            // Update rules
            if ($request->has('rules')) {
                $this->discountService->saveDiscountRules($discount, $request->rules);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Discount created successfully!',
                'redirect_url' => route('admin.discount.index')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.' . $e->getMessage()
            ]);
        }
    }

    /**
     * Handle coupons update (create/update/delete)
     */
    protected function handleCouponsUpdate(Discount $discount, array $couponsData)
    {
        $existingCouponIds = $discount->coupons->pluck('id')->toArray();
        $submittedCouponIds = [];

        foreach ($couponsData as $couponData) {
            if (isset($couponData['id'])) {
                // Update existing coupon
                $coupon = Coupon::find($couponData['id']);
                if ($coupon) {
                    $coupon->update([
                        'code' => $couponData['code'],
                        'description' => $couponData['description'] ?? null,
                        'starts_at' => $couponData['starts_at'] ?? null,
                        'expires_at' => $couponData['expires_at'] ?? null,
                        'usage_limit' => $couponData['usage_limit'] ?? null,
                        'usage_limit_per_user' => $couponData['usage_limit_per_user'] ?? null,
                        'min_order_amount' => $couponData['min_order_amount'] ?? null,
                        'is_active' => $couponData['is_active'] ?? true,
                    ]);
                    $submittedCouponIds[] = $coupon->id;
                }
            } else {
                // Create new coupon
                $coupon = $this->discountService->createCoupon([
                    'discount_id' => $discount->id,
                    'code' => $couponData['code'],
                    'description' => $couponData['description'] ?? null,
                    'starts_at' => $couponData['starts_at'] ?? null,
                    'expires_at' => $couponData['expires_at'] ?? null,
                    'usage_limit' => $couponData['usage_limit'] ?? null,
                    'usage_limit_per_user' => $couponData['usage_limit_per_user'] ?? null,
                    'min_order_amount' => $couponData['min_order_amount'] ?? null,
                    'is_active' => $couponData['is_active'] ?? true,
                ]);
                $submittedCouponIds[] = $coupon->id;
            }
        }

        // Delete coupons that weren't submitted
        $couponsToDelete = array_diff($existingCouponIds, $submittedCouponIds);
        if (!empty($couponsToDelete)) {
            Coupon::whereIn('id', $couponsToDelete)->delete();
        }
    }

    /**
     * Remove the specified discount and its related data.
     */
    public function destroy(Discount $discount)
    {
        try {
            DB::transaction(function () use ($discount) {
                $discount->coupons()->delete();
                $discount->rules()->delete();
                $discount->delete();
            });

            return redirect()->route('discount.index')
                ->with('success', 'Discount and all related data deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete discount: ' . $e->getMessage());
        }
    }

    /**
     * Toggle discount active status and its coupons.
     */
    public function toggleStatus(Discount $discount)
    {
        try {
            DB::transaction(function () use ($discount) {
                $newStatus = !$discount->is_active;
                $discount->update(['is_active' => $newStatus]);
                $discount->coupons()->update(['is_active' => $newStatus]);
            });

            return back()->with('success', 'Discount status and related coupons updated');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to toggle status: ' . $e->getMessage());
        }
    }

    /**
     * Validate a coupon code (AJAX endpoint)
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'order_total' => 'nullable|numeric'
        ]);

        $coupon = $this->discountService->validateCoupon(
            $request->code,
            $request->user_id ? User::find($request->user_id) : null,
            $request->order_total
        );

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code'
            ], 404);
        }

        return response()->json([
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $coupon->discount
        ]);
    }

    /**
     * Apply coupon to order
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'coupon_code' => 'required|string'
        ]);

        $order = Order::find($request->order_id);

        try {
            $result = $this->discountService->applyToOrder($order, $request->coupon_code);
            return back()->with('success', 'Coupon applied successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}