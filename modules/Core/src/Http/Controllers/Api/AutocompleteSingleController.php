<?php

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AutocompleteSingleController extends Controller
{
    public function index(Request $request)
    {
        // Validate input parameters
        $validator = Validator::make($request->all(), [
            'table' => 'required|string',
            'select_columns' => 'required|string',
            'search_column' => 'required|string',
            'query' => 'sometimes|string|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid parameters',
                'errors' => $validator->errors()
            ]);
        }

        // Get validated input
        $table = $request->input('table');
        $selectColumns = $request->input('select_columns');
        $searchColumn = $request->input('search_column');
        $query = $request->input('query');

        // Convert select_columns to array
        $columns = array_map('trim', explode(',', $selectColumns));

        // Basic security check - validate table and column names
        if (!$this->validateTableAndColumns($table, $columns, $searchColumn)) {
            return response()->json([
                'error' => 'Invalid table or column name'
            ]);
        }

        try {
            // Build the query
            $results = DB::table($table)
                ->select($columns);

            // Add search condition if query exists
            if (!empty($query)) {
                $results->where($searchColumn, 'LIKE', '%' . $query . '%');
            }

            // Limit results for autocomplete
            $results = $results->limit(10)->get();


            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Database error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enhanced validation for table and column names with support for aliases
     */
    protected function validateTableAndColumns($table, $columns, $searchColumn)
    {
        // Add your allowed tables here for security
        $allowedTables = ['admins', 'users', 'categories', 'countries', 'country_states', 'roles', 'coupons'];

        if (!in_array($table, $allowedTables)) {
            return false;
        }

        // Parse columns if they're in a string format
        if (is_string($columns)) {
            $columns = array_map('trim', explode(',', $columns));
        }

        // Merge all columns to check
        $allColumns = array_merge($columns, [$searchColumn]);

        // Enhanced column name validation with support for aliases
        foreach ($allColumns as $column) {
            // Check if the column contains an alias (AS keyword)
            if (stripos($column, ' as ') !== false) {
                // Split into actual column and alias
                $parts = preg_split('/\s+as\s+/i', $column);
                if (count($parts) !== 2) {
                    return false;
                }

                $actualColumn = trim($parts[0]);
                $alias = trim($parts[1]);

                // Validate both the actual column and the alias
                if (
                    !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $actualColumn) ||
                    !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $alias)
                ) {
                    return false;
                }
            } else {
                // Simple column name validation
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
                    return false;
                }
            }
        }

        return true;
    }
}
