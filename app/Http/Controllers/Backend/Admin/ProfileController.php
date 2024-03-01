<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Backend\Profile\ProfileUpdateRequest;
use App\Traits\FileControlTrait;

class ProfileController extends Controller
{
    use FileControlTrait;

    public function edit()
    {
        $admin = Auth::user();
        return view('backend.admin.profile.edit', compact('admin'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get the authenticated user
        $user = $request->user();

        if (!$user || $user->status != 'active' || $user->role != 'admin') {
            abort(401, 'unauthorized');
        }

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $this->deleteFile($user->photo);
            $data['photo'] = $this->uploadFile($request->file('photo'), 'users/profile');
        }

        $user->fill($data);

        // If the email has changed, reset the email verification status
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $notification = [
            'message' => 'Admin Profile updated successfully!',
            'alert-type' => 'success'
        ];

        // Redirect back with a success message
        return redirect()->back()->with($notification);
    }
}