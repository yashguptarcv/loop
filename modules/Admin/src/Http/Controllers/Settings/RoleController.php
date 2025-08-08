<?php

namespace Modules\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\RoleService;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\DataView\Settings\RolesGrid;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $lists = fn_datagrid(RolesGrid::class)->process();
        return view('admin::settings.roles.index', compact('lists'));
     
    }

    public function create()
    {
        return view('admin::settings.roles.form', ['role' => null]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles|max:128',
            'description' => 'nullable|string|max:256',
            'permission_type' => 'required|in:all,custom',
            'permissions' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->permission_type === 'custom' && (empty($value) || count($value) === 0)) {
                        $fail('The permissions field is required when permission type is custom.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $this->roleService->store($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully!',
                'redirect_url' => route('admin.settings.roles.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name,' . $id,
            'description' => 'nullable|string',
            'permission_type' => 'required|in:all,custom',
            'permissions' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->permission_type === 'custom' && (empty($value) || count($value) === 0)) {
                        $fail('The permissions field is required when permission type is custom.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            $this->roleService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully!',
                'redirect_url' => route('admin.settings.roles.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $role = $this->roleService->find($id);
        return view('admin::settings.roles.form', compact('role'));
    }

    public function destroy($id)
    {
        try {
            $this->roleService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!',
                'redirect_url' => route('admin.settings.roles.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:roles,id', 
        ]);
        try {
            $deletedCount = $this->roleService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.roles.index')->with('success', 'Roles Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.roles.index')->with('error', 'Something went wrong. Please try again.');

        }
    }
}
