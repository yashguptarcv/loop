<?php

namespace Modules\Admin\Http\Controllers\Settings\Statuses;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Modules\Admin\Models\Tag;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Admin\Models\LeadStatusesModels;
use Modules\Admin\DataView\Settings\Statuses\LeadTag;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(LeadTag::class)->process();
        $tags = Tag::all();
        return view('admin::settings.statuses.tags.index', compact('lists', 'tags'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('admin::settings.statuses.tags.form', compact('tags'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tags' => 'required|array',

            'tags.*.name' => 'required_without:tags.new|string|max:255',
            'tags.*.color' => 'nullable|string|max:255',

            // Validate new tags:
            'tags.new' => 'array',
            'tags.new.*.name' => 'required|string|max:255',
            'tags.new.*.color' => 'nullable|string|max:255',

            'deleted_tags' => 'sometimes|array',
            'deleted_tags.*' => 'exists:tags,id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            // Handle deleted tags
            if ($request->has('deleted_tags')) {
                Tag::whereIn('id', $request->deleted_tags)->delete();
                Log::debug('Deleted tags:', ['deleted_tags' => $request->deleted_tags]);
            }

            foreach ($request->input('tags', []) as $key => $tagGroup) {
                if ($key === 'new') {
                    // Loop through new tags
                    foreach ($tagGroup as $tagData) {
                        Tag::create([
                            'name' => $tagData['name'],
                            'color' => $tagData['color'] ?? null,
                        ]);
                    }
                } else {
                    // Existing tags logic, update or create as fallback 

                    if (!empty($tagGroup['id']) && is_numeric($tagGroup['id'])) {
                        $tag = Tag::find($tagGroup['id']);
                        if ($tag) {
                            $tag->name = $tagGroup['name'];
                            $tag->color = $tagGroup['color'] ?? null;
                            if ($tag->isDirty()) {
                                $tag->save();
                            }
                        } else {
                            Tag::create([
                                'name' => $tagGroup['name'],
                                'color' => $tagGroup['color'] ?? null,
                            ]);
                        }
                    } else {
                        Tag::create([
                            'name' => $tagGroup['name'],
                            'color' => $tagGroup['color'] ?? null,
                        ]);
                    }
                }
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tags saved successfully!',
                'redirect_url' => route('admin.settings.statuses.leads.index')
            ]);
        } catch (\Throwable $e) {
            \DB::rollBack();
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
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $user = Tag::update($id, [
                'name'  => $request['name'],
                'color'  => $request['color'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead tag updated successfully!',
                'redirect_url' => route('admin.settings.statuses.index'),
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
        $tag = Tag::find($id);

        if ($tag) {
            $tag->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tag not found.']);
        }
    }
}
