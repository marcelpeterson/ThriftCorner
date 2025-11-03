@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-3xl">
        <div class="mb-8 max-md:text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Edit Profile
            </h1>
            <p class="mt-2 text-gray-600">
                Update your personal information below.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Profile Photo Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Profile Photo</h2>
                
                <!-- Success/Error Messages for Photo Update -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex items-center space-x-6">
                    <!-- Current Photo -->
                    <div class="shrink-0">
                        @if($user->photo)
                            <img class="h-24 w-24 object-cover rounded-full"
                                 src="{{ $user->photo }}"
                                 alt="Profile photo">
                        @else
                            <img class="h-24 w-24 object-cover rounded-full"
                                 src="{{ Avatar::create($user->first_name . ' ' . $user->last_name)->toBase64() }}"
                                 alt="Profile photo">
                        @endif
                    </div>
                    
                    <!-- Photo Upload Form -->
                    <div class="flex-1">
                        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-900 mb-2">
                                    Upload New Photo
                                </label>
                                <input
                                    type="file"
                                    id="photo"
                                    name="photo"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer @error('photo') border-red-500 @enderror"
                                />
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="max-md:hidden mt-1 text-xs text-gray-500">Allowed formats: JPEG, PNG, JPG, GIF. Maximum size: 2MB</p>
                                <div class="sm:hidden mt-2">
                                    <p class="mt-1 text-xs text-gray-500">Formats: JPEG, PNG, JPG, GIF</p>
                                    <p class="mt-1 text-xs text-gray-500">Maximum size: 2MB</p>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors cursor-pointer"
                            >
                                Update Photo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <hr class="my-8">
            
            <!-- Personal Information Section -->
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Personal Information</h2>
            
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

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-900">
                        Location
                    </label>
                    <select
                        id="location"
                        name="location"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('location') border-red-500 @enderror"
                    >
                        <option value="">Select your region</option>
                        <option value="Jakarta - Kemanggisan" {{ old('location', $user->location) == 'Jakarta - Kemanggisan' ? 'selected' : '' }}>Jakarta - Kemanggisan</option>
                        <option value="Jakarta - Syahdan" {{ old('location', $user->location) == 'Jakarta - Syahdan' ? 'selected' : '' }}>Jakarta - Syahdan</option>
                        <option value="Jakarta - Senayan" {{ old('location', $user->location) == 'Jakarta - Senayan' ? 'selected' : '' }}>Jakarta - Senayan</option>
                        <option value="Tangerang - Alam Sutera" {{ old('location', $user->location) == 'Tangerang - Alam Sutera' ? 'selected' : '' }}>Tangerang - Alam Sutera</option>
                        <option value="Bekasi" {{ old('location', $user->location) == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                        <option value="Bandung" {{ old('location', $user->location) == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                        <option value="Semarang" {{ old('location', $user->location) == 'Semarang' ? 'selected' : '' }}>Semarang</option>
                        <option value="Malang" {{ old('location', $user->location) == 'Malang' ? 'selected' : '' }}>Malang</option>
                        <option value="Medan" {{ old('location', $user->location) == 'Medan' ? 'selected' : '' }}>Medan</option>
                    </select>
                    @error('location')
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

        <!-- Password Change Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Change Password</h2>
            
            <!-- Success/Error Messages for Password Update -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-900">
                        Current Password
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                    />
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">
                        New Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900">
                        Confirm New Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror"
                    />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-md bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors cursor-pointer"
                    >
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
