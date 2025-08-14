<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AutoCompleteController extends Controller
{
    public function index(Request $request)
    {
        // Validate input parameters
        $validator = Validator::make($request->all(), [
            'table' => 'required|string',
            'select_columns' => 'required|string',
            'search_column' => 'required|string',
            'q' => 'sometimes|string|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid parameters',
                'errors' => $validator->errors()
            ], 400);
        }

        // Get validated input
        $table = $request->input('table');
        $selectColumns = $request->input('select_columns');
        $searchColumn = $request->input('search_column');
        $query = $request->input('q', '');

        // Convert select_columns to array
        $columns = array_map('trim', explode(',', $selectColumns));

        // Basic security check - validate table and column names
        if (!$this->validateTableAndColumns($table, $columns, $searchColumn)) {
            return response()->json([
                'error' => 'Invalid table or column name'
            ], 400);
        }

        try {
            // Build the query
            $results = DB::table($table)
                ->select($columns);

            // Add search condition if query exists
            if (!empty($query)) {
                $results->where($searchColumn, 'LIKE', '%'.$query.'');
            }

            // Limit results for autocomplete
            $results = $results->limit(10)->get();

            return response()->json($results);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Basic validation for table and column names
     */
    protected function validateTableAndColumns($table, $columns, $searchColumn)
    {
        // Add your allowed tables here for security
        $allowedTables = ['admins', 'users', 'categories', 'countries', 'country_states']; // Example
        
        if (!in_array($table, $allowedTables)) {
            return false;
        }

        // Merge all columns to check
        $allColumns = array_merge($columns, [$searchColumn]);

        // Very basic column name validation
        foreach ($allColumns as $column) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
                return false;
            }
        }

        return true;
    }
}