<?php

namespace Modules\Admin\Http\Controllers\Settings\Statuses;

use Modules\Admin\Models\LeadStatusesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Modules\Admin\Models\LeadSource as SourceModel;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Admin\DataView\Settings\Statuses\LeadSource;

class SourceController extends Controller
{
    public function index(Request $request)
    {
        $sources = SourceModel::all();
        return view('admin::settings.statuses.sources.index', compact('sources'));
    }

    public function create()
    {
        $sources = SourceModel::all();
        return view('admin::settings.statuses.sources.form', compact('sources'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sources' => 'required|array',
            'sources.*.name' => 'required_without:sources.new|string|max:255',
            'sources.*.is_active' => 'nullable|numeric',

            // Validate new sources:
            'sources.new' => 'array',
            'sources.new.*.name' => 'required|string|max:255',
            'sources.new.*.is_active' => 'nullable|numeric',

            'deleted_sources' => 'sometimes|array',
            'deleted_sources.*' => 'exists:sources,id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            // Handle deleted sources
            if ($request->has('deleted_sources')) {
                SourceModel::whereIn('id', $request->deleted_sources)->delete();
                Log::debug('Deleted sources:', ['deleted_sources' => $request->deleted_sources]);
            }

            foreach ($request->input('sources', []) as $key => $sourceGroup) {
                if ($key === 'new') {
                    // Loop through new sources
                    foreach ($sourceGroup as $sourceData) {
                        SourceModel::create([
                            'name' => $sourceData['name'],
                            'is_active' => $sourceData['is_active'] ?? null,
                        ]);
                    }
                } else {
                    // Existing sources logic, update or create as fallback 

                    if (!empty($sourceGroup['id']) && is_numeric($sourceGroup['id'])) {
                        $source = SourceModel::find($sourceGroup['id']);
                        if ($source) {
                            $source->name = $sourceGroup['name'];
                            $source->is_active = $sourceGroup['is_active'] ?? null;
                            if ($source->isDirty()) {
                                $source->save();
                            }
                        } else {
                            SourceModel::create([
                                'name' => $sourceGroup['name'],
                                'is_active' => $sourceGroup['is_active'] ?? null,
                            ]);
                        }
                    } else {
                        SourceModel::create([
                            'name' => $sourceGroup['name'],
                            'is_active' => $sourceGroup['is_active'] ?? null,
                        ]);
                    }
                }
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'sources saved successfully!',
                'redirect_url' => route('admin.settings.statuses.leads.index')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $lead = LeadStatusesModels::where('id', $id)->first();
        if (!$lead) {
            return redirect()->route('admin.settings.statuses.index')->with('error', 'Lead statuses not found.');
        }
        return view('admin::settings.statuses.form', compact('lead'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $user = SourceModel::update($id, [
                'name'  => $request['name'],
                'is_active'  => $request['is_active'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead Source updated successfully!',
                'redirect_url' => route('admin.settings.statuses.index'),
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
        $source = SourceModel::find($id);

        if ($source) {
            $source->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Source not found.']);
        }
    }
}
