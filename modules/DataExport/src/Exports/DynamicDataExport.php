<?php

namespace Modules\DataExport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class DynamicDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $table;
    protected array $columns;
    protected array $filters;

    public function __construct(string $table, array $columns = [], array $filters = [])
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = DB::table($this->table);

        if (!empty($this->columns)) {
            $query->select($this->columns);
        }

        foreach ($this->filters as $filter) {
            if (isset($filter['column'], $filter['operator'], $filter['value'])) {
                $query->where($filter['column'], $filter['operator'], $filter['value']);
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        if (!empty($this->columns)) {
            return $this->columns;
        }

        $firstRow = $this->collection()->first();
        return $firstRow ? array_keys((array) $firstRow) : [];
    }

    public function map($row): array
    {
        return array_values((array) $row);
    }
}