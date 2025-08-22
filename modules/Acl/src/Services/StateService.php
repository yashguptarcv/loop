<?php

namespace Modules\Acl\Services;

use Modules\Acl\Models\Admin;
use Modules\Acl\Models\Currency;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\CountryState;
use Illuminate\Database\Eloquent\Model;

class StateService
{

    public function create(array $data)
    {
        return CountryState::create([
            'country_id' => $data['country_id'],
            'code' => $data['code'],
            'default_name' => $data['default_name'],
        ]);
    }

    public function update(int $id, array $data)
    {
        $countryState = CountryState::findOrFail($id);
        $countryState->update([
            'country_id' => $data['country_id'],

            'code' => $data['code'],
            'default_name' => $data['default_name'],
        ]);

        return $countryState;
    }

    public function delete(int $id)
    {
        $countryState = CountryState::findOrFail($id);
        $countryState->delete();
        return true;
    }

    public function updateCurrency(array $ids, int $status): int
    {
        return CountryState::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function deleteMultiple(array $ids): int
    {
        return CountryState::whereIn('id', $ids)->delete();
    }


    public function find(int $id)
    {
        return CountryState::findOrFail($id);
    }
}
