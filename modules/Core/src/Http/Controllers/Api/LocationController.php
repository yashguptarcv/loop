<?php

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Models\CountryState;

class LocationController extends Controller
{
    public function states(Request $request, $id)
    {
        $states = CountryState::where('country_id', $id);
        return response()->json($states->select('id', 'default_name as name')->orderBy('default_name')->get());
    }
}
