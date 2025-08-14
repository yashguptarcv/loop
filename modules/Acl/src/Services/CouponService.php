<?php

namespace Modules\Acl\Services;

use Modules\Admin\Models\Coupon;

class CouponService
{
    public function create(array $data)
    {
        return Coupon::create([
            'admin_id' => $data['admin_id'],
            'name' => $data['name'],
            'coupon_code' => $data['coupon_code'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'coupon_per_user' => $data['coupon_per_user'],
            'coupon_used_count' => $data['coupon_used_count'],

            'coupon_type' => $data['coupon_type'],
            'coupon_value' => $data['coupon_value'],
            'coupon_status' => $data['coupon_status'],
            'coupon_message' => $data['coupon_message'],
        ]);
    }

    public function update(int $id, array $data)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'name' => $data['name'],
            'coupon_code' => $data['coupon_code'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'coupon_per_user' => $data['coupon_per_user'],
            'coupon_used_count' => $data['coupon_used_count'],

            'coupon_type' => $data['coupon_type'],
            'coupon_value' => $data['coupon_value'],
            'coupon_status' => $data['coupon_status'],
            'coupon_message' => $data['coupon_message'],
        ]);

        return $coupon;
    }

    public function delete(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return true;
    }

    public function toggleStatus(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return $coupon->status;
    }

    public function updateCoupon(array $ids, int $status): int
    {
        return Coupon::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function deleteMultiple(array $ids): int
    {
        return Coupon::whereIn('id', $ids)->delete();
    }


    public function find(int $id)
    {
        return Coupon::findOrFail($id);
    }
}
