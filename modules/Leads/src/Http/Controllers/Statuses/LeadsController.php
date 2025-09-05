<?php

namespace Modules\Leads\Http\Controllers\Statuses;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Modules\Leads\Models\Tag;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Leads\Models\LeadStatusesModels;
use Modules\Leads\DataView\Statuses\LeadStatuses;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(LeadStatuses::class)->process();
        return view('leads::statuses.leads.index', compact('lists'));
    }

    public function create()
    {
        $roles = Role::all();
        $tags = Tag::all();
        return view('leads::statuses.leads.form', compact('roles', 'tags'));
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'sort' => 'required|integer',
            'is_default' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $user = LeadStatusesModels::create([
                'name'  => $request['name'],
                'color'  => $request['color'],
                'sort'  => $request['sort'],
                'is_default'  => $request['is_default']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead statuses created successfully!',
                'redirect_url' => route('admin.statuses.leads.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $tags = Tag::all();
        $lead = LeadStatusesModels::where('id', $id)->first(); // You should already have a method like this in your service
        if (!$lead) {
            return redirect()->route('admin.statuses.leads.index')->with('error', 'Lead statuses not found.');
        }
        return view('leads::statuses.leads.form', compact('lead', 'tags'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'sort' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $user = LeadStatusesModels::update($id, [
                'name'  => $request['name'],
                'color'  => $request['color'],
                'sort'  => $request['sort']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead statuses updated successfully!',
                'redirect_url' => route('admin.statuses.leads.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            LeadStatusesModels::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Lead status deleted',
                'redirect_url' => route('admin.statuses.leads.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }
}
