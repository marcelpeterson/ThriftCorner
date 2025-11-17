<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Laravolt\Avatar\Facade as Avatar;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function registerSubmit(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:50|regex:/^[a-zA-Z\-]+$/',
            'last_name'  => 'required|string|max:50|regex:/^[a-zA-Z\-]+$/',
            'email'      => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(binus\.ac\.id|binus\.edu)$/'
            ],
            'password'   => 'required|min:6|confirmed',
            'phone'      => 'required|string|min:10|max:12',
            'location'   => 'required|in:Jakarta - Kemanggisan,Jakarta - Syahdan,Jakarta - Senayan,Tangerang - Alam Sutera,Bekasi,Bandung,Semarang,Malang,Medan',
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.max' => 'The first name may not be greater than 50 characters.',
            'first_name.regex' => 'The first name must contain only letters and hyphens.',
            'last_name.required' => 'The last name field is required.',
            'last_name.max' => 'The last name may not be greater than 50 characters.',
            'last_name.regex' => 'The last name must contain only letters and hyphens.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'email.regex' => 'The email must be a valid binus.ac.id or binus.edu address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'phone.required' => 'The phone number field is required.',
            'phone.min' => 'The phone number must be at least 10 characters.',
            'phone.max' => 'The phone number may not be greater than 12 characters.',
            'location.required' => 'The location field is required.',
            'location.in' => 'The selected location is invalid.',
        ]);

        $user = new User();
        $user->first_name = ucfirst(strtolower($request->first_name));
        $user->last_name  = ucfirst(strtolower($request->last_name));
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->location   = $request->location;
        $user->photo_url  = Avatar::create($request->first_name . ' ' . $request->last_name)->toBase64();
        $user->password   = Hash::make($request->password);
        $user->save();

        // Fire the Registered event to trigger email verification
        event(new Registered($user));

        // Log in the user automatically after registration
        Auth::login($user);

        return redirect()->route('profile')
            ->with('verification_required', 'Registration successful! Please check your email to verify your account.');
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
            
            // Redirect admin users to dashboard
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }
            
            // Check if user's email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('profile')->with('verification_required', 'Please verify your email address to access all features.');
            }
            
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
