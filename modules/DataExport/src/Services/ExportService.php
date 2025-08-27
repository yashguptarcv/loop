<?php

namespace Modules\DataExport\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Modules\DataExport\Exports\DynamicDataExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportService
{
    public function getAvailableTables(): array
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        
        return array_filter($tables, function ($table) {
            return !in_array($table, ['migrations', 'password_resets', 'failed_jobs']);
        });
    }

    public function getTableColumns(string $table): array
    {
        try {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);
            return array_combine($columns, $columns);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTableData(string $table, array $columns = [], array $filters = [], int $limit = 1000): array
    {
        $query = DB::table($table);

        // Select specific columns or all
        if (!empty($columns)) {
            $query->select($columns);
        }

        // Apply filters
        foreach ($filters as $filter) {
            if (isset($filter['column'], $filter['operator'], $filter['value'])) {
                $query->where($filter['column'], $filter['operator'], $filter['value']);
            }
        }

        $data = $query->limit($limit)->get();

        return [
            'headers' => array_keys((array) $data->first() ?? []),
            'rows' => $data->toArray(),
            'total' => $data->count()
        ];
    }

    public function exportData(string $table, array $columns = [], array $filters = [], string $format = 'csv'): BinaryFileResponse
    {
        $export = new DynamicDataExport($table, $columns, $filters);
        
        $filename = $table . '_export_' . now()->format('Y-m-d_H-i-s');

        return match($format) {
            'xlsx' => Excel::download($export, $filename . '.xlsx'),
            'pdf' => Excel::download($export, $filename . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF),
            'json' => $this->exportJson($export, $filename),
            default => Excel::download($export, $filename . '.csv'),
        };
    }

    protected function exportJson(DynamicDataExport $export, string $filename): BinaryFileResponse
    {
        $data = $export->collection()->toArray();
        
        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }, $filename . '.json');
    }
}