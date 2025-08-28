<?php

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function search(Request $request)
    {
        $table = $request->get('table');
        $valueField = $request->get('value_field');
        $searchFields = explode(',', $request->get('search_fields'));
        $q = $request->get('q');

        $query = DB::table($table);
        foreach ($searchFields as $field) {
            $query->orWhere($field, 'like', "%$q%");
        }
        return response()->json($query->limit(10)->get());
    }

    public function list(Request $request)
    {
        $table = $request->get('table');
        $listAttributes = explode(',', $request->get('list_attributes'));
        $searchFields = explode(',', $request->get('search_fields'));
        $q = $request->get('q');
        $sort = $request->get('sort');

        $query = DB::table($table);
        if ($q) {
            foreach ($searchFields as $field) {
                $query->orWhere($field, 'like', "%$q%");
            }
        }
        if ($sort) $query->orderBy($sort);

        $items = $query->paginate(100);

        // Actions injected from module
        $actions = [];        

        return view('core::components.autocomplete.popup', compact('items', 'listAttributes', 'table', 'actions'));
    }
}
