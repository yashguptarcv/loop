<?php

namespace Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class AdminPermissionMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = auth()->guard('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login.form');
        }

        if (!$user->status) {
            auth('admin')->logout();
            return redirect()->route('admin.login.form');
        }

        $role = $user->role;

        if (!$role || ($role->permission_type !== 'all' && empty($role->permissions))) {
            auth('admin')->logout();
            session()->flash('error', 'Your account has no permissions assigned.');
            return redirect()->route('admin.login.form');
        }

        $routeName = Route::currentRouteName();

        if ($role->permission_type !== 'all' && !in_array($routeName, $role->permissions ?? [])) {
            abort(401, 'Unauthorized route access');
        }

        return $next($request);
    }
}
