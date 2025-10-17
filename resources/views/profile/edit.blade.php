@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Edit Profile
            </h1>
            <p class="mt-2 text-gray-600">
                Update your personal information below.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-900">
                        First Name
                    </label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name', $user->first_name) }}"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('first_name') border-red-500 @enderror"
                    />
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-900">
                        Last Name
                    </label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name', $user->last_name) }}"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('last_name') border-red-500 @enderror"
                    />
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('email') border-red-500 @enderror"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-900">
                        Phone Number
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                    />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors cursor-pointer"
                    >
                        Save Changes
                    </button>
                    <a
                        href="{{ route('profile') }}"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
