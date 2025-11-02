@extends('layouts.app')

@section('title', 'My Premium Upgrades - ' . config('app.name'))

@section('content')
<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 max-md:text-2xl">My Premium Upgrades</h1>
            <p class="text-gray-600 text-sm mt-2">Track all your premium listing purchases and promotions</p>
        </div>

        @if($payments->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Premium Upgrades Yet</h3>
                <p class="text-gray-600 mb-6">You haven't purchased any premium listings yet.</p>
                <a href="{{ route('items') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Browse Items
                </a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($payments as $payment)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="mb-4">
                                {{-- Mobile: Row layout --}}
                                <div class="md:hidden flex items-start justify-between gap-3 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">
                                            @if($payment->item)
                                                <a href="{{ route('items.view', $payment->item->slug) }}" class="hover:text-emerald-600 transition-colors">
                                                    {{ $payment->item->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">Item Deleted</span>
                                            @endif
                                        </h3>
                                        
                                        @if($payment->premiumListing)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                @if($payment->premiumListing->package_type === 'hero') bg-purple-100 text-purple-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                                {{ $payment->premiumListing->package_type === 'hero' ? '⭐ Hero' : '✨ Featured' }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-right flex-shrink-0">
                                    @if($payment->status === 'pending')
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Pending
                                        </span>
                                    @elseif($payment->status === 'success')
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Confirmed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Failed
                                        </span>
                                    @endif
                                    
                                    <p class="text-sm font-bold text-gray-900 mt-1">
                                        {{ rupiah($payment->amount) }}
                                    </p>
                                    </div>
                                </div>
                                
                                {{-- Mobile: Order info below --}}
                                <div class="md:hidden flex flex-col items-start gap-1.5 text-xs text-gray-600 mb-3">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        #{{ $payment->order_id }}
                                    </span>
                                    
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 mb-0.25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $payment->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                {{-- Desktop: Original layout --}}
                                <div class="hidden md:flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                @if($payment->item)
                                                    <a href="{{ route('items.view', $payment->item->slug) }}" class="hover:text-emerald-600 transition-colors">
                                                        {{ $payment->item->name }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">Item Deleted</span>
                                                @endif
                                            </h3>
                                            
                                            @if($payment->premiumListing)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($payment->premiumListing->package_type === 'hero') bg-purple-100 text-purple-800
                                                    @else bg-blue-100 text-blue-800
                                                    @endif">
                                                    {{ $payment->premiumListing->package_type === 'hero' ? '⭐ Hero Banner' : '✨ Featured' }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                Order #{{ $payment->order_id }}
                                            </span>
                                            
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $payment->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right ml-4">
                                        @if($payment->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @elseif($payment->status === 'success')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Confirmed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Failed
                                            </span>
                                        @endif
                                        
                                        <p class="text-lg font-bold text-gray-900 mt-2">
                                            {{ rupiah($payment->amount) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($payment->premiumListing)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600 mb-1">Duration</p>
                                            <p class="font-semibold text-gray-900">{{ $payment->premiumListing->duration_days }} days</p>
                                        </div>
                                        
                                        @if($payment->premiumListing->activated_at)
                                            <div>
                                                <p class="text-gray-600 mb-1">Activated</p>
                                                <p class="font-semibold text-gray-900">{{ $payment->premiumListing->activated_at->format('d M Y') }}</p>
                                            </div>
                                        @endif
                                        
                                        @if($payment->premiumListing->expires_at)
                                            <div>
                                                <p class="text-gray-600 mb-1">Expires</p>
                                                <p class="font-semibold {{ $payment->premiumListing->expires_at->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                                    {{ $payment->premiumListing->expires_at->format('d M Y') }}
                                                </p>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <p class="text-gray-600 mb-1">Status</p>
                                            <p class="font-semibold {{ $payment->premiumListing->is_active ? 'text-green-600' : 'text-gray-900' }}">
                                                {{ $payment->premiumListing->is_active ? 'Active' : 'Inactive' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4 flex flex-wrap justify-end gap-2">
                                @if($payment->item)
                                    <a href="{{ route('items.view', $payment->item->slug) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View Item
                                    </a>
                                @endif
                                
                                <a href="{{ route('payment.status', $payment->id) }}" 
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($payments->hasPages())
                <div class="mt-8">
                    {{ $payments->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
