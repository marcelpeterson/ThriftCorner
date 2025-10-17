<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = Auth::user();

        $user->update(['email' => $request->email]);
        $user->email_verified_at = null;
        $user->save();

        // Send new verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('status', 'Your email has been updated. A new verification link has been sent to your new email address.');
    }
}
