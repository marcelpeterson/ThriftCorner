<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected ImageOptimizationService $imageOptimizer;

    public function __construct(ImageOptimizationService $imageOptimizer)
    {
        $this->imageOptimizer = $imageOptimizer;
    }
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated();
        
        // Handle photo upload if present
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo_url) {
                // Check if the old photo is in the R2 storage
                if (Storage::disk('r2')->exists($user->photo_url)) {
                    Storage::disk('r2')->delete($user->photo_url);
                }
                // Also check in public storage for backward compatibility
                elseif (Storage::disk('public')->exists($user->photo_url)) {
                    Storage::disk('public')->delete($user->photo_url);
                }
            }

            // Upload and optimize new photo
            $photo = $request->file('photo');
            $path = $this->imageOptimizer->optimizeAndStore($photo, 'profile-photos', 'r2');
            $data['photo_url'] = $path;
        }

        $user->update($data);

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

    public function updatePhoto(UpdateProfilePhotoRequest $request)
    {
        $user = Auth::user();
        
        // Delete old photo if exists
        if ($user->photo_url) {
            // Check if the old photo is in the R2 storage
            if (Storage::disk('r2')->exists($user->photo_url)) {
                Storage::disk('r2')->delete($user->photo_url);
            }
            // Also check in public storage for backward compatibility
            elseif (Storage::disk('public')->exists($user->photo_url)) {
                Storage::disk('public')->delete($user->photo_url);
            }
        }

        // Upload and optimize new photo
        $photo = $request->file('photo');
        $path = $this->imageOptimizer->optimizeAndStore($photo, 'profile-photos', 'r2');

        // Update user's photo URL
        $user->update(['photo_url' => $path]);

        return redirect()->route('profile.edit')->with('success', 'Profile photo updated successfully!');
    }
}
