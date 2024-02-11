<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Logout successfully!',
            'alert-type' => 'success'
        ];

        return redirect('/login')->with($notification);
    }
}