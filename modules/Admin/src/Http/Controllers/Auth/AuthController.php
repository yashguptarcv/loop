<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService('admin');
    }
    public function showLogin()
    {
        return view('admin::auth.login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $ip = $request->ip();

        if ($this->authService->hasTooManyLoginAttempts($ip)) {
            return response()->json([
                'errors' => ['email' => ['Too many attempts. Try again later.']],
            ]);
        }

        if ($this->authService->login($request->only('email', 'password'))) {
            $this->authService->clearLoginAttempts($ip);
            
            return response()->json([
                'success' => true,
                'message' => 'Login successfully!',
                'redirect_url' => route('admin.index'),
            ]);
        }

        $this->authService->incrementLoginAttempts($ip);

        return response()->json([
            'errors' => ['email' => ['Invalid credentials']],
        ]);
    }


    public function logout(Request $request)
    {
        $this->authService->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully!',
            'redirect_url' => route('admin.login.form')
        ]);

    }
}