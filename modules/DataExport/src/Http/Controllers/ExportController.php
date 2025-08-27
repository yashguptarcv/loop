<?php

namespace Modules\DataExport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataExport\Services\ExportService;
use Modules\DataExport\Http\Requests\ExportRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    protected ExportService $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        $tables = $this->exportService->getAvailableTables();
        $formats = config('dataexport.export_formats');

        return view('dataexport::index', compact('tables', 'formats'));
    }

    public function getColumns(string $table)
    {
        $columns = $this->exportService->getTableColumns($table);
        
        return response()->json([
            'success' => true,
            'columns' => $columns
        ]);
    }

    public function preview(Request $request, string $table)
    {
        $data = $this->exportService->getTableData(
            $table,
            $request->get('columns', []),
            $request->get('filters', []),
            $request->get('limit', 10)
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function export(ExportRequest $request): BinaryFileResponse
    {
        $validated = $request->validated();

        return $this->exportService->exportData(
            $validated['table'],
            $validated['columns'] ?? [],
            $validated['filters'] ?? [],
            $validated['format']
        );
    }
}