<?php

namespace Modules\Acl\Support;

class Bouncer
{
    public function hasPermission(string $permission): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && $admin->hasPermission($permission);
    }

    public static function allow(string $permission): void
    {
        $admin = auth()->guard('admin')->user();

        if (! $admin || ! $admin->hasPermission($permission)) {
            abort(401, 'This action is unauthorized.');
        }
    }
}
