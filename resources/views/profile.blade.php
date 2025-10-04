@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-3xl text-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Your Profile
        </h1>
        <p class="mt-4 text-gray-600">
            Manage your personal information and view your listings.
        </p>
    </div>

    <div class="mt-10 max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Personal Information</h2>
        <div class="flex items-center justify-between mt-6 mb-6">
            <div>
                <div class="mb-2 flex items-center space-x-6">
                    <img src="{{ $user->photo_url }}" alt="User photo" class="w-20 h-20 rounded-full">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Rating</h3>
                {{-- <p class="text-yellow-500">⭐⭐⭐⭐⭐</p> --}}
                <p class="text-sm text-gray-600">No review yet</p>
            </div>
    
            <div>
                <button class="inline-flex items-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:text-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all">
                    <a href="#">Edit</a>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-10 max-w-5xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 ml-6">Your Listings</h2>
        @if(count($items) > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <x-listing-card :item="$item" />
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600">You have no listings. Start selling your items now!</p>
        @endif
    </div>
</div>
@endsection