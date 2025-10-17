<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
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
}
