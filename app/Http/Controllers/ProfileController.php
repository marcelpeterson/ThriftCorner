<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        
        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully!');
    }
}
