@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section aria-labelledby="login-title" class="min-h-[50vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 id="login-title" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">Sign in to your account</h1>
        <div class="mt-2 flex items-center justify-center gap-1">
            <p class="text-sm font-medium text-gray-700">Don't have an account?</p>
            <a href="{{ route('register') }}" class="text-sm font-medium text-blue-500 hover:text-blue-800">Create Account</a>
        </div>

        <form action="{{route('login.submit')}}" class="mt-6" method="POST" id="loginForm">
            @csrf
            <div class="flex flex-col gap-3">
                <input type="text" name="email" placeholder="Email" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                <input type="password" name="password" placeholder="Password" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                <button type="submit" id="loginButton" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-[12px] mt-2 w-full cursor-pointer flex items-center justify-center">
                    <span id="loginText">Login</span>
                    <div id="loginSpinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Signing in...</span>
                    </div>
                </button>
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-500 hover:text-blue-800">
                Forgot Your Password?
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('loginText');
    const spinner = document.getElementById('loginSpinner');
    
    form.addEventListener('submit', function() {
        // Disable button to prevent double click
        button.disabled = true;
        button.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Show spinner and hide text
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        spinner.classList.add('flex', 'items-center');
    });
});
</script>
@endpush
