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
            session()->flash('error', 'No account found with this email.');
            return redirect()->route('admin.login.form');
        }

        if (!$user->status) {
            auth('admin')->logout();
            session()->flash('error', 'Your account has been not active.');
            return redirect()->route('admin.login.form');
        }

        $role = $user->role;

        if (!$role || ($role->permission_type !== 'all' && empty($role->permissions))) {
            auth('admin')->logout();
            abort(401, 'Unauthorized route access');
        }

        $routeName = Route::currentRouteName();

        if ($role->permission_type !== 'all' && !in_array($routeName, $role->permissions ?? [])) {
            abort(401, 'Unauthorized route access');
        }

        return $next($request);
    }
}
