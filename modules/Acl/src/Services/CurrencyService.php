<?php

namespace Modules\Acl\Services;

use Modules\Acl\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyService
{
    // public function listCurrencies()
    // {
    //     return Currency::with('role')->latest()->get();
    // }

    public function create(array $data)
    {
        return Currency::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'symbol' => $data['symbol'],
            'decimal' => $data['decimal'],
        ]);
    }

    public function update(int $id, array $data)
    {
        $currency = Currency::findOrFail($id);
        $currency->update([
            'code' => $data['code'],
            'name' => $data['name'],
            'symbol' => $data['symbol'],
            'decimal' => $data['decimal'],
        ]);
        
        return $currency;
    }

    public function delete(int $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return true;
    }

    public function toggleStatus(int $id)
    {
        $currency = Admin::findOrFail($id);
        $currency->status = !$currency->status;
        $currency->save();

        return $currency->status;
    }

    public function updateCurrency(array $ids, int $status): int
    {
        return Currency::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function deleteMultiple(array $ids): int
    {
        return Currency::whereIn('id', $ids)->delete();
    }


    public function find(int $id)
    {
        return Currency::findOrFail($id);
    }
}
