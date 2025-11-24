@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<section aria-labelledby="forgot-password-title" class="min-h-[50vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <h1 id="forgot-password-title" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">Forgot Your Password?</h1>
        <p class="mt-2 text-center text-sm text-gray-600">
            No problem. Just enter your email address below, and we'll send you a
            password reset link that will allow you to choose a new one.
        </p>

        @if (session('status') && session('success'))
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('password.email') }}" class="mt-6" method="POST" id="forgotPasswordForm">
            @csrf
            <div class="flex flex-col gap-3">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email Address" 
                    value="{{ old('email') }}"
                    class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required
                    autofocus
                />
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                <button type="submit" id="forgotPasswordButton" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-[12px] mt-2 w-full cursor-pointer flex items-center justify-center">
                    <span id="forgotPasswordText">Send Password Reset Link</span>
                    <div id="forgotPasswordSpinner" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Sending reset link...</span>
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
    const form = document.getElementById('forgotPasswordForm');
    if (form) {
        const button = document.getElementById('forgotPasswordButton');
        const buttonText = document.getElementById('forgotPasswordText');
        const spinner = document.getElementById('forgotPasswordSpinner');
        
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