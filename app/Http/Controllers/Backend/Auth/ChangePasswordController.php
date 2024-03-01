<?php

namespace App\Http\Controllers\Backend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        $admin = Auth::user();
        return view('backend.admin.profile.change-password', compact('admin'));
    }

    /**
     * Update the user's password.
     */

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $notification = [
            'message' => 'Password updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}