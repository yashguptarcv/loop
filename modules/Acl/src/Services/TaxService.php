<?php

namespace Modules\Acl\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\TaxRate;

class TaxService
{

    public function create(array $data)
    {
        return TaxRate::create([
            // 'code' => $data['code'],
            // 'name' => $data['name'],
            // 'symbol' => $data['symbol'],
            // 'decimal' => $data['decimal'],
        ]);
    }

    public function update(int $id, array $data)
    {
       
    }

    public function delete(int $id)
    {
       
    }

    public function toggleStatus(int $id)
    {
      
    }

    public function updateCurrency(array $ids, int $status)
    {
    }

    public function deleteMultiple(array $ids)
    {
    }


    public function find(int $id)
    {
    }
}
