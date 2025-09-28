@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="py-10">
    <div class="mx-auto max-w-3xl text-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Welcome to {{ config('app.name', 'ThriftCorner') }}
        </h1>
        <p class="mt-4 text-gray-600">
            A simple marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
        </p>
        <div class="mt-8 flex items-center justify-center gap-3">
            @if (Route::has('listings.index'))
                <a href="{{ route('listings.index') }}"
                   class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                    Browse Listings
                </a>
            @endif
            @auth
                @if (Route::has('listings.create'))
                    <a href="{{ route('listings.create') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800">
                        Sell an Item
                    </a>
                @endif
            @endauth
        </div>
    </div>

    {{-- <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Textbooks</h3>
            <p class="mt-1 text-sm text-gray-600">Buy and sell used textbooks for your courses.</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Electronics</h3>
            <p class="mt-1 text-sm text-gray-600">Laptops, phones, and accessories, secondhand and affordable.</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Dorm Essentials</h3>
            <p class="mt-1 text-sm text-gray-600">Furniture and essentials for boarding life.</p>
        </div>
    </div> --}}

    <div>
        @if(count($items) > 0)
            <h2 class="mt-12 text-2xl font-bold text-gray-900">Explore ThriftCorner</h2>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <div class="rounded-lg border border-gray-200 bg-white p-6">
                        <div class="flex items-center gap-1">
                            <img src="{{ $item->user->photo_url }}" alt="User photo from API" class="w-10 h-10 rounded-full object-cover inline-block">
                            <div>
                                <p class="text-sm font-medium text-gray-900 inline-block ml-2">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
                                <p class="text-xs text-gray-500 ml-2">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($item->photo_url)
                            <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="mt-3 w-96 h-96 object-cover rounded-md">
                        @else
                            <div class="mt-4 w-full h-48 bg-gray-100 flex items-center justify-center rounded-md">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $item->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($item->description, 100) }}</p>
                            <p class="mt-2 text-md font-semibold text-gray-900">{{ $item->price_rupiah }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $item->condition }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-12 text-center text-gray-600">No listings available at the moment. Please check back later.</p>
        @endif
    </div>
</div>
@endsection
