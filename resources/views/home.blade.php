@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="py-10">
    {{-- <div class="mx-auto max-w-3xl text-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Welcome to {{ config('app.name', 'ThriftCorner') }}
        </h1>
        <p class="mt-4 text-gray-600">
            A simple marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
        </p>
    </div> --}}

    <div class="bg-gray-900 flex items-center rounded-[48px] overflow-hidden">
        <div class="text-white ml-12 self-center pb-8">
            <h1 class="text-[4rem] font-bold tracking-tight sm:text-[4rem]">
                {{ config('app.name', 'ThriftCorner') }}
            </h1>
            <p class="mt-4 text-3xl font-bold text-gray-100">
                Binusian favorite place for second-hand gems.
            </p>
            <p class="mt-2 text-gray-300">
                A simple marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
            </p>
        </div>
        <img src="{{ asset('storage/images/bags.png') }}" alt="" class="w-full max-w-[400px] ml-auto">
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
                    <x-listing-card :item="$item" />
                @endforeach
            </div>
        @else
            <p class="mt-12 text-center text-gray-600">No listings available at the moment. Please check back later.</p>
        @endif
    </div>
</div>
@endsection
