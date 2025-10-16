@extends('layouts.app')

@section('title', 'Manage Listings - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manage Listings</h1>
            <p class="text-gray-600 mt-1">View and manage all platform listings</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
            ← Back to Dashboard
        </a>
    </div>

    {{-- Listings Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($listings as $listing)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                {{-- Image --}}
                <div class="relative h-48 overflow-hidden">
                    @if($listing->images->count() > 0)
                        {{-- Blurred Background --}}
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($listing->images->first()->image_path) }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                        </div>
                        {{-- Actual Image --}}
                        <img src="{{ Storage::url($listing->images->first()->image_path) }}" alt="{{ $listing->name }}" class="relative w-full h-full object-contain z-10">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    
                    @if($listing->is_sold)
                        <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold z-20">
                            SOLD
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-2 truncate">{{ $listing->name }}</h3>
                    <p class="text-xl font-bold text-emerald-600 mb-2">{{ $listing->price_rupiah }}</p>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $listing->category->name }}</span>
                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">{{ $listing->condition }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                        @if($listing->user->photo_url)
                            <img src="{{ $listing->user->photo_url }}" alt="{{ $listing->user->first_name }}" class="w-6 h-6 rounded-full object-cover">
                        @else
                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 text-xs font-bold">{{ substr($listing->user->first_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <span>{{ $listing->user->first_name }}</span>
                    </div>

                    <p class="text-xs text-gray-500 mb-3">Posted {{ $listing->created_at->diffForHumans() }}</p>

                    <div class="flex gap-2">
                        <a href="{{ route('items.view', $listing->slug) }}" target="_blank"
                           class="flex-1 px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-sm font-medium text-center transition-colors">
                            View
                        </a>
                        <form action="{{ route('admin.listings.delete', $listing) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors cursor-pointer">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    {{-- <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        {{ $listings->links() }}
    </div> --}}
</div>
@endsection
