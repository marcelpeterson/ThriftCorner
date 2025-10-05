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

        <form action="{{route('login.submit')}}" class="mt-6" method="POST">
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
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-[12px] mt-2 w-full cursor-pointer">Login</button>
            </div>
        </form>
    </div>
</section>

@endsection
