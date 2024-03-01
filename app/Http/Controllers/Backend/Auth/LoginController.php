<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login()
    {
        return view('backend.auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /**
         * redirect the user based on the role he or she has;
         * - if admin redirect to admin/dashoard
         * - if a regular user redirect to dashboard
         */

        $home = '';

        if ($request->user()->role === 'admin') {
            $home = '/admin/dashboard';
        } elseif ($request->user()->role === 'sales') {
            $home = '/dashboard';
        } elseif ($request->user()->role === 'user') {
            $home = '/dashboard';
        }

        $notification = [
            'message' => 'Sign In successfully!',
            'alert-type' => 'success'
        ];

        // return redirect()->intended(RouteServiceProvider::HOME);
        return redirect()->intended($home)->with($notification);
    }
}