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

    <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
    </div>
</div>
@endsection
