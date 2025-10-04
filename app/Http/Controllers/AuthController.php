<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function registerSubmit(Request $request) 
    {
 
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'phone'      => 'required|string|min:10|max:12',
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 50 characters.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 50 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'phone.required' => 'The phone number field is required.',
            'phone.min' => 'The phone number must be at least 10 characters.',
            'phone.max' => 'The phone number may not be greater than 12 characters.',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->name       = $request->first_name . ' ' . $request->last_name; 
        $user->email      = $request->email;
        $user->password   = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login() 
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
   
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
        ]);

    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Welcome back!');
        }

      
        return redirect()->back()->withErrors([
            'email' => 'Incorrect email or password.',
        ]);
         }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function profile()
    {
        $user = Auth::user();
        $items = Item::where('user_id', $user->id)->get();
        return view('profile', compact('user', 'items'));
    }
}
