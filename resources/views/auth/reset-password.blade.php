@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<section aria-labelledby="reset-password-title" class="min-h-[50vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 id="reset-password-title" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">Reset Password</h1>
        <p class="mt-2 text-center text-sm text-gray-600">
            Enter your new password below to reset your account password.
        </p>

        @if (session('success'))
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('password.update') }}" class="mt-6" method="POST" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="flex flex-col gap-3">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email Address" 
                    value="{{ old('email') ?? request('email') }}"
                    class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required
                    autofocus
                />
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                
                <input 
                    type="password" 
                    name="password" 
                    placeholder="New Password" 
                    class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required
                />
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                
                <input 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="Confirm New Password" 
                    class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required
                />
                @error('password_confirmation')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                
                <button type="submit" id="resetPasswordButton" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-[12px] mt-2 w-full cursor-pointer flex items-center justify-center">
                    <span id="resetPasswordText">Reset Password</span>
                    <div id="resetPasswordSpinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Resetting password...</span>
                    </div>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-blue-500 hover:text-blue-800">
                Back to Login
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetPasswordForm');
    if (form) {
        const button = document.getElementById('resetPasswordButton');
        const buttonText = document.getElementById('resetPasswordText');
        const spinner = document.getElementById('resetPasswordSpinner');
        
        form.addEventListener('submit', function() {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');
            spinner.classList.add('flex', 'items-center');
        });
    }
});
</script>
@endpush