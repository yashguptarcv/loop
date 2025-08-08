<?php

namespace Modules\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Admin\DataView\Settings\UsersGrid;

class UserAdminController extends Controller
{
    protected $userAdminService;

    public function __construct(UserAdminService $userAdminService)
    {
        $this->userAdminService = $userAdminService;
    }

    public function index(Request $request)
    {
        $lists = fn_datagrid(UsersGrid::class)->process();
        return view('admin::settings.users.index', compact('lists'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin::settings.users.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = $this->userAdminService->create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Admin created successfully!',
                'redirect_url' => route('admin.settings.users.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function show($id)
    {
        $user = $this->userAdminService->find($id); // You should already have a method like this in your service
        if (!$user) {
            return redirect()->route('admin.settings.users.index')->with('error', 'User not found.');
        }
        $roles = Role::all();
        return view('admin::settings.users.form', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:128',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($id)],
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $user = $this->userAdminService->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Admin updated successfully!',
                'redirect_url' => route('admin.settings.users.index'),
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $this->userAdminService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Admin deleted',
                'redirect_url' => route('admin.settings.users.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:admins,id',
            'action' => 'required|in:0,1'
        ]);

        try {
            $updatedCount = $this->userAdminService->updateStatuses($request->ids, $request->action);
            return redirect()->route('admin.settings.users.index')->with('success', 'Status Updated Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.users.index')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:admins,id',
        ]);
        try {
            $deletedCount = $this->userAdminService->deleteMultiple($request->ids);
            return redirect()->route('admin.settings.users.index')->with('success', 'Bulk Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.users.index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
