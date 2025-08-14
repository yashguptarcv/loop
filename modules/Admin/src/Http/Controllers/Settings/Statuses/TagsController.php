<?php

namespace Modules\Admin\Http\Controllers\Settings\Statuses;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;
use Modules\Admin\Models\LeadStatusesModels;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(LeadStatuses::class)->process();
        return view('admin::settings.statuses.leads.index', compact('lists'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin::settings.statuses.leads.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'sort' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = LeadStatusesModels::create([
                'name'  => $request['name'],
                'color'  => $request['color'],
                'sort'  => $request['sort']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead statuses created successfully!',
                'redirect_url' => route('admin.settings.statuses.leads.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $lead = LeadStatusesModels::where('id', $id)->first(); // You should already have a method like this in your service
        if (!$lead) {
            return redirect()->route('admin.settings.statuses.leads.index')->with('error', 'Lead statuses not found.');
        }
        return view('admin::settings.statuses.leads.form', compact('lead'));
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
            ], 422);
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
                'redirect_url' => route('admin.settings.statuses.leads.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            LeadStatusesModels::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Lead status deleted',
                'redirect_url' => route('admin.settings.statuses.leads.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:lead_statuses,id',
        ]);
        try {
            $deletedCount = LeadStatusesModels::destroy($request->ids);
            return redirect()->route('admin.settings.statuses.leads.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.statuses.leads.index')->with('error', $e->getMessage());
        }
    }
}
