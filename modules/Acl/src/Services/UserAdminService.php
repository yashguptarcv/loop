<?php

namespace Modules\Acl\Services;

use Modules\Acl\Models\Admin;
use Illuminate\Support\Facades\Hash;

class UserAdminService
{
    public function listUsers()
    {
        return Admin::with('role')->latest()->get();
    }

    public function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'status' => true,
        ]);
    }

    public function update(int $id, array $data)
    {
        $user = Admin::findOrFail($id);
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
        ]);

        if (!empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        return $user;
    }

    public function delete(int $id)
    {
        $user = Admin::findOrFail($id);
        $user->delete();
        return true;
    }

    public function toggleStatus(int $id)
    {
        $user = Admin::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return $user->status;
    }

    public function updateStatuses(array $ids, int $status): int
    {
        return Admin::whereIn('id', $ids)->update(['status' => $status]);
    }

    public function deleteMultiple(array $ids): int
    {
        return Admin::whereIn('id', $ids)->delete();
    }


    public function find(int $id)
    {
        return Admin::findOrFail($id);
    }
}
