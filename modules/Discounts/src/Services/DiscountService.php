<?php

namespace Modules\Discounts\Services;

use Exception;
use Illuminate\Support\Str;
use Modules\Orders\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Models\User;
use Modules\Discounts\Models\Coupon;
use Modules\Discounts\Models\Discount;
use Modules\Discounts\Models\DiscountRule;

class DiscountService
{
    /**
     * Create a new discount with its coupons and rules
     *
     * @param array $data
     * @return Discount
     * @throws Exception
     */
    public function createDiscount(array $data): Discount
    {
        return DB::transaction(function () use ($data) {
            // Create the discount
            $discount = Discount::create([
                'name' => $data['name'],
                'admin_id' => auth('admin')->id(),
                'description' => $data['description'] ?? null,
                'type' => $data['type'],
                'amount' => $data['amount'],
                'apply_to' => $data['apply_to'] ?? 'subtotal',
                'user_groups' => $data['user_groups'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'starts_at' => $data['starts_at'] ?? null,
                'expires_at' => $data['expires_at'] ?? null,
            ]);

            // Create default coupon if not provided
            if (!isset($data['coupons'])) {
                $this->createDefaultCoupon($discount);
            }

            // Create provided coupons
            if (isset($data['coupons']) && is_array($data['coupons'])) {
                foreach ($data['coupons'] as $couponData) {
                    $this->createCouponForDiscount($discount, $couponData);
                }
            }

            // Create discount rules
            if (isset($data['rules']) && is_array($data['rules'])) {
                $this->saveDiscountRules($discount, $data['rules']);
            }

            return $discount;
        });
    }

    /**
     * Create a default coupon for a discount
     *
     * @param Discount $discount
     * @return Coupon
     */
    public function createDefaultCoupon(Discount $discount): Coupon
    {
        return Coupon::create([
            'discount_id' => $discount->id,
            'code' => Str::upper(Str::random(8)),
            'description' => 'Auto-generated coupon for discount: ' . $discount->name,
            'is_active' => $discount->is_active,
            'starts_at' => $discount->starts_at,
            'expires_at' => $discount->expires_at,
        ]);
    }

    /**
     * Create a coupon for a discount
     *
     * @param Discount $discount
     * @param array $data
     * @return Coupon
     */
    public function createCouponForDiscount(Discount $discount, array $data): Coupon
    {
        return Coupon::create([
            'discount_id' => $discount->id,
            'code' => $data['code'],
            'description' => $data['description'] ?? null,
            'starts_at' => $data['starts_at'] ?? $discount->starts_at,
            'expires_at' => $data['expires_at'] ?? $discount->expires_at,
            'usage_limit' => $data['usage_limit'] ?? null,
            'usage_limit_per_user' => $data['usage_limit_per_user'] ?? null,
            'min_order_amount' => $data['min_order_amount'] ?? null,
            'is_active' => $data['is_active'] ?? $discount->is_active,
        ]);
    }

    /**
     * Save discount rules
     *
     * @param Discount $discount
     * @param array $rules
     * @return void
     */
    public function saveDiscountRules(Discount $discount, array $rules): void
    {
        // First delete existing rules
        $discount->rules()->delete();

        // Add new rules
        foreach ($rules as $rule) {
            DiscountRule::create([
                'discount_id' => $discount->id,
                'rule_type' => $rule['rule_type'],
                'rule_id' => $rule['rule_id'],
                'condition_type' => $rule['condition_type'],
                'rule_value' => $rule['rule_value'] ?? null,
            ]);
        }
    }

    /**
     * Create a coupon
     *
     * @param array $data
     * @return Coupon
     */
    public function createCoupon(array $data): Coupon
    {
        return Coupon::create([
            'discount_id' => $data['discount_id'],
            'code' => $data['code'],
            'description' => $data['description'] ?? null,
            'starts_at' => $data['starts_at'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'usage_limit' => $data['usage_limit'] ?? null,
            'usage_limit_per_user' => $data['usage_limit_per_user'] ?? null,
            'min_order_amount' => $data['min_order_amount'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Validate a coupon code
     *
     * @param string $code
     * @param User|null $user
     * @param object|array|null $order
     * @return Coupon|null
     */
    public function validateCoupon(string $code, ?User $user = null, $order = null): ?Coupon
    {
        $coupon = Coupon::where('code', $code)
            ->with(['discount.rules']) // eager load discount rules
            ->first();

        if (!$coupon) {
            return null;
        }

        if (!$coupon->is_active) {
            return null;
        }

        $now = now();
        if ($coupon->starts_at && $now->lt($coupon->starts_at)) {
            return null;
        }
        if ($coupon->expires_at && $now->gt($coupon->expires_at)) {
            return null;
        }

        if ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit) {
            return null;
        }

        if ($user && $coupon->usage_limit_per_user) {
            $userUsage = DB::table('coupon_user')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $user->id)
                ->count();

            if ($userUsage >= $coupon->usage_limit_per_user) {
                return null;
            }
        }


        $orderTotal = $coupon->discount->apply_to->value === 'total'
            ? $order['total']
            : $order['subtotal'];

        if ($coupon->min_order_amount && $orderTotal < $coupon->min_order_amount) {
            return null;
        }

        foreach ($coupon->discount->rules as $rule) {
            switch ($rule->rule_type) {
                case 'product':
                    $productQty = collect($order['order_items'] ??  $order['items'])
                        ->where('product_id', $rule->rule_id)
                        ->sum('quantity');

                    if (!$this->checkCondition($productQty, $rule->condition_type, $rule->rule_value)) {
                        return null; // product rule not satisfied
                    }
                    break;

                // case 'category':
                //     $categoryQty = collect($order['order_items'])
                //         ->where('category_id', $rule->rule_id)
                //         ->sum('quantity');

                //     if (!$this->checkCondition($categoryQty, $rule->condition_type, $rule->rule_value)) {
                //         return null; // category rule not satisfied
                //     }
                //     break;

                case 'subtotal':
                    if (!$this->checkCondition($order['subtotal'], $rule->condition_type, $rule->rule_value)) {
                        return null; // subtotal rule not satisfied
                    }
                    break;

                case 'total':
                    if (!$this->checkCondition($order['total'], $rule->condition_type, $rule->rule_value)) {
                        return null; // total rule not satisfied
                    }
                    break;

                default:
                    return null; // unknown rule
            }
        }

        return $coupon;
    }

    protected function checkCondition($value, string $condition, $ruleValue): bool
    {
        switch ($condition) {
            case 'equals':
                return $value == $ruleValue;
            case 'not_equals':
                return $value != $ruleValue;
            case 'greater_than':
                return $value > $ruleValue;
            case 'greater_or_equal':
                return $value >= $ruleValue;
            case 'less_than':
                return $value < $ruleValue;
            case 'less_or_equal':
                return $value <= $ruleValue;
            case 'any': // condition always passes if item exists
                return $value > 0;
            default:
                return false;
        }
    }


    /**
     * Apply coupon to an order and return discount details
     *
     * @param string $couponCode
     * @param object|array $order
     * @return float
     * @throws Exception
     */
    public function applyCoupon(string $couponCode, $order): array
    {
        // Validate the coupon first
        $coupon = $this->validateCoupon($couponCode, null, $order);

        if (!$coupon) {
            return [];
        }

        $discount = $coupon->discount;

        // Calculate discount amount based on discount type
        $discountAmount = 0;
        if ($discount->apply_to == 'subtotal') {

            $orderTotal = $order['subtotal'];
        } elseif ($discount->apply_to == 'total') {

            $orderTotal = $order['total'];
        } else {

            $orderTotal = $order['subtotal'];
        }

        switch ($discount->type->value) {
            case 'F': // Fixed amount
                $discountAmount = min($discount->amount, $orderTotal);
                break;

            case 'P': // Percentage
                $discountAmount = $orderTotal * ($discount->amount / 100);
                break;
        }

        // Round to 2 decimal places
        $discountAmount = round($discountAmount, 2);

        return [
            'coupon' => $coupon,
            'discount' => $discount,
            'discount_amount' => $discountAmount,
            'discount_type' => $discount->type->value,
            'apply_to' => $discount->apply_to,
        ];
    }


    /**
     * Calculate discount amount based on discount type
     *
     * @param Discount $discount
     * @param Order $order
     * @return float
     */
    protected function calculateDiscountAmount(Discount $discount, Order $order): float
    {
        $amount = 0;

        switch ($discount->type) {
            case 'F':
                $amount = $discount->amount;
                break;
            case 'P':
                $baseAmount = $discount->apply_to === 'shipping'
                    ? $order->shipping_amount
                    : $order->subtotal;
                $amount = $baseAmount * ($discount->amount / 100);
                break;
            case 'free_shipping':
                $amount = $order->shipping_amount;
                break;
        }

        return round($amount, 2);
    }
}
