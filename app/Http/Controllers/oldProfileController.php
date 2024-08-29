<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OldProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get the authenticated user
        $user = $request->user();

        // old photo if it exists
        $old_image = $user->photo;

        // Fill the user model with validated data except for the image
        $user->fill($request->except('photo'));

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
}
