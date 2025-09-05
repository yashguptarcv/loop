<?php

namespace Modules\Acl\Services;

use Modules\Acl\Models\Role;

class RoleService
{
    public function listRoles()
    {
        return Role::all();
    }

    public function store(array $data)
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->description = $data['description'] ?? null;
        $role->permission_type = $data['permission_type'];
        $role->permissions = $data['permission_type'] === 'custom'
            ? $data['permissions'] ?? []
            : [];
        $role->save();
        return $role;
    }

    public function update($roleId, array $data)
    {
        $role = Role::findOrFail($roleId);

        $role->name = $data['name'];
        $role->description = $data['description'] ?? null;
        $role->permission_type = $data['permission_type'];
        $role->permissions = $data['permission_type'] === 'custom'
            ? $data['permissions']?? []
            : [];
        $role->save();

        return $role;
    }

    public function find($roleId)
    {
        return Role::findOrFail($roleId);
    }

    public function delete($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();
        return true;
    }

    public function deleteMultiple(array $ids): int
    {
        return Role::whereIn('id', $ids)->delete();
    }

}
