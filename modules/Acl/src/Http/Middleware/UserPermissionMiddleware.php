<?php

namespace Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class UserPermissionMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            session()->flash('error', 'No account found with this email.');
            return redirect()->route('customer.login');
        }

        // if (!$user->status) {
        //     auth('customer')->logout();
        //     session()->flash('error', 'Your account has been not active.');
        //     return redirect()->route('customer.login');
        // }

        // $role = $user->role;

        // if (!$role || ($role->permission_type !== 'all' && empty($role->permissions))) {
        //     auth('customer')->logout();
        //     abort(401, 'Unauthorized route access');
        // }

        // $routeName = Route::currentRouteName();

        // if ($role->permission_type !== 'all' && !in_array($routeName, $role->permissions ?? [])) {
        //     abort(401, 'Unauthorized route access');
        // }

        return $next($request);
    }
}
