<?php

namespace App\Http\Controllers\Frontend\Profile;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Frontend\Profile\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('frontend.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // old photo if it exists
        $old_image = $user->photo;

        // Fill the user model with validated data except for the image
        $user->fill($request->except('photo', 'role'));

        // Check if an image is uploaded
        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $user->photo = $new_image;
        }


        if ($old_image && $new_image) {
            // Delete the old photo
            Storage::disk('public')->delete(str_replace('storage/', '', $old_image));
        }

        // If the email has changed, reset the email verification status
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the changes to the database
        $user->save();

        $notification = [
            'message' => 'Profile updated successfully!',
            'alert-type' => 'success'
        ];

        // Redirect back with a success message
        return redirect()->back()->with($notification);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('photo')) {
            return;
        }

        if ($request->hasFile('photo')) {
            $file  = $request->file('photo');

            $path  = $file->store('uploads/users', [
                'disk' => 'public'
            ]);

            return $path;
        }
    }

    public function changePassword()
    {
        return view('frontend.profile.change-password');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}