<?php

namespace Modules\Acl\Services;

use Modules\Admin\Models\Country;

class CountryService
{
    public function create(array $data)
    {
        return Country::create([
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
    }

    public function update(int $id, array $data)
    {
        $country = Country::findOrFail($id);
        $country->update([
            'code' => $data['code'],
            'name' => $data['name'],
        ]);
        
        return $country;
    }

    public function delete(int $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        return true;
    }

    public function toggleStatus(int $id)
    {
        $country = Country::findOrFail($id);
        $country->status = !$country->status;
        $country->save();

        return $country->status;
    }

    public function updateCountry(array $ids, int $status): int
    {
        return Country::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function deleteMultiple(array $ids): int
    {
        return Country::whereIn('id', $ids)->delete();
    }


    public function find(int $id)
    {
        return Country::findOrFail($id);
    }
}
