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
                <h3 class="text-lg font-semibold text-gray-900">Seller Rating</h3>
                @if($user->total_ratings > 0)
                    <div class="flex items-center gap-2">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($user->average_rating))
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @elseif($i - 0.5 <= $user->average_rating)
                                    <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24">
                                        <defs>
                                            <linearGradient id="half-fill-{{ $i }}">
                                                <stop offset="50%" stop-color="currentColor" stop-opacity="1"/>
                                                <stop offset="50%" stop-color="#D1D5DB" stop-opacity="1"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#half-fill-{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-gray-700">{{ $user->average_rating }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Based on {{ $user->total_ratings }} {{ Str::plural('review', $user->total_ratings) }}</p>
                @else
                    <p class="text-sm text-gray-600">No reviews yet</p>
                @endif
            </div>
    
            <div>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:text-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all">
                    Edit
                </a>
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