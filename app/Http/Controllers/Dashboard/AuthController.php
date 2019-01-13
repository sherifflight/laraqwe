<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\AuthRequest;

class AuthController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('dashboard.login');
    }

    /**
     * @param AuthRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthRequest $request)
    {
        $loginData = $request->only('email', 'password');
        $remember = $request->has('remember') ? true : false;
        if (! auth('dashboard')->attempt($loginData, $remember)) {
            return $this->error(['Неверный email и/или пароль.']);
        }
        return redirect()->intended(route('dashboard'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth('dashboard')->logout();
        return redirect()->route('dashboard.login');
    }
}
