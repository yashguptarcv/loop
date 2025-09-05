<?php

namespace Modules\Customers\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Services\AuthCustomerService;

class AuthCustomerController extends Controller
{
    protected AuthCustomerService $authCustomerService;

    public function __construct()
    {
        $this->authCustomerService = new AuthCustomerService('customer');
    }
    public function showLogin()
    {
        return view('customers::auth.login');
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

        if ($this->authCustomerService->hasTooManyLoginAttempts($ip)) {
            return response()->json([
                'errors' => ['email' => ['Too many attempts. Try again later.']],
            ]);
        }

        if ($this->authCustomerService->login($request->only('email', 'password'))) {
            $this->authCustomerService->clearLoginAttempts($ip);
            session([
                'currency'  => fn_get_setting('general.currency.customer'),
                'language'  => fn_get_setting('general.language'),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Login successfully!',
                'redirect_url' => '/'
            ]);
        }

        $this->authCustomerService->incrementLoginAttempts($ip);

        return response()->json([
            'errors' => ['email' => ['Invalid credentials']],
        ]);
    }


    public function logout(Request $request)
    {
        $this->authCustomerService->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully!',
            'redirect_url' => route('customer.login.form')
        ]);

    }
}