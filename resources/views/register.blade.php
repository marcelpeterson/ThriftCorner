@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section aria-labelledby="register-title" class="min-h-[50vh] flex items-center justify-center">
    <div class="flex gap-8 items-center max-md:flex-col px-4">
        <div>
            <img src="https://storage.thriftcorner.store/assets/binus-register.png" alt="Binus Register" class="w-[400px] max-md:hidden">
        </div>
        <div class="max-w-md w-full p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">Create an account</h1>
            <div class="mt-2 flex items-center justify-center gap-1">
                <p class="text-sm font-medium text-gray-700">Already have an account?</p>
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-500 hover:text-blue-800">Login</a>
            </div>
    
            <form action="{{ route('register.submit')}}" method="POST">
                @csrf
                <div class="flex flex-col gap-3 mt-6">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col">
                            <input type="text" name="first_name" placeholder="First name" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('first_name')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <input type="text" name="last_name" placeholder="Last name" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('last_name')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <input type="text" name="email" placeholder="Email" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('email')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <input type="password" name="password" placeholder="Password" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('password')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('password_confirmation')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <input type="text" name="phone" placeholder="Phone Number" class="border border-gray-500 rounded-[12px] px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('phone')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-[12px] mt-2 w-full cursor-pointer">Register</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection