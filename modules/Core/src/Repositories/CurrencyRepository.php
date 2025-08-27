<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Currency;
use Illuminate\Support\Collection;

class CurrencyRepository
{
    public function getAll(): Collection
    {
        return Currency::all();
    }

    public function findByCode(string $code): ?Currency
    {
        return Currency::where('code', $code)->first();
    }

    public function getById(int $id): ?Currency
    {
        return Currency::find($id);
    }
}
