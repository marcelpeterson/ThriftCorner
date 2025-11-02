@extends('layouts.app')

@section('title', 'My Transactions')

@section('content')
<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Transactions</h1>
            <p class="mt-2 text-sm text-gray-600">View and manage your buying and selling transactions</p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-md bg-green-50 p-3 sm:p-4 border border-green-200">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md bg-red-50 p-3 sm:p-4 border border-red-200">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($transactions->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-8 sm:py-12 bg-white rounded-lg shadow">
                <svg class="mx-auto h-10 sm:h-12 w-10 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-xs sm:text-sm font-medium text-gray-900">No transactions</h3>
                <p class="mt-1 text-xs sm:text-sm text-gray-500">You haven't participated in any transactions yet.</p>
                <div class="mt-4 sm:mt-6">
                    <a href="{{ route('items') }}" class="inline-flex items-center px-3 sm:px-4 py-2 border border-transparent shadow-sm text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 sm:h-5 w-4 sm:w-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Items
                    </a>
                </div>
            </div>
        @else
            <!-- Transactions List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach ($transactions as $transaction)
                        <li class="hover:bg-gray-50 transition-colors">
                            <div class="px-3 sm:px-6 py-4 sm:py-5">
                                <div class="flex flex-col gap-4 md:flex-row md:justify-between">
                                    <!-- Top Row: Image and Basic Info -->
                                    <div class="flex max-md:flex-col gap-3 sm:gap-6">
                                        <!-- Item Image -->
                                        <div class="flex-shrink-0 relative">
                                            @if ($transaction->item->images->isNotEmpty())
                                                {{-- Blurred Background --}}
                                                <div class="absolute inset-0 rounded-lg overflow-hidden md:hidden">
                                                    <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                                                </div>
                                                {{-- Actual Image --}}
                                                <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}"
                                                     alt="{{ $transaction->item->name }}"
                                                     class="relative h-32 sm:h-44 w-full sm:w-48 rounded-lg object-contain md:object-cover">
                                            @else
                                                <div class="h-16 sm:h-44 w-full sm:w-48 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                                    <svg class="h-8 sm:h-10 w-8 sm:w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Transaction Details -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-row sm:items-center gap-2 mb-1 sm:mb-2">
                                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">
                                                    {{ $transaction->item->name }}
                                                </h3>
                                                <!-- Status Badge -->
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusColor = $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }} whitespace-nowrap">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </div>

                                            <p class="text-lg sm:text-lg font-semibold text-emerald-600 mb-2">
                                                Rp {{ number_format($transaction->item->price, 0, ',', '.') }}
                                            </p>

                                            <div class="text-xs sm:text-sm text-gray-600 space-y-1">
                                                <!-- Role -->
                                                <p class="flex items-center">
                                                    <span class="font-medium mr-2">Role:</span>
                                                    @if ($transaction->seller_id === auth()->id())
                                                        <span class="text-blue-600 font-medium">Seller</span>
                                                    @else
                                                        <span class="text-purple-600 font-medium">Buyer</span>
                                                    @endif
                                                </p>

                                                <!-- Other Party -->
                                                <p class="flex items-center">
                                                    <span class="font-medium mr-2">
                                                        @if ($transaction->seller_id === auth()->id())
                                                            Buyer:
                                                        @else
                                                            Seller:
                                                        @endif
                                                    </span>
                                                    <span class="truncate">
                                                        @if ($transaction->seller_id === auth()->id())
                                                            @if ($transaction->buyer)
                                                                {{ $transaction->buyer->first_name }} {{ $transaction->buyer->last_name }}
                                                            @else
                                                                <span class="text-gray-400 italic">Not yet confirmed</span>
                                                            @endif
                                                        @else
                                                            {{ $transaction->seller->first_name }} {{ $transaction->seller->last_name }}
                                                        @endif
                                                    </span>
                                                </p>

                                                <!-- Confirmation Status -->
                                                <div class="flex items-center gap-2 sm:gap-4 mt-2 flex-wrap">
                                                    <span class="flex items-center">
                                                        @if ($transaction->seller_confirmed)
                                                            <svg class="h-4 sm:h-5 w-4 sm:w-5 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            <svg class="h-4 sm:h-5 w-4 sm:w-5 text-gray-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                        <span class="text-xs">Seller confirmed</span>
                                                    </span>
                                                    <span class="flex items-center">
                                                        @if ($transaction->buyer_confirmed)
                                                            <svg class="h-4 sm:h-5 w-4 sm:w-5 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        @else
                                                            <svg class="h-4 sm:h-5 w-4 sm:w-5 text-gray-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                        <span class="text-xs">Buyer confirmed</span>
                                                    </span>
                                                </div>

                                                <!-- Date -->
                                                <p class="text-xs text-gray-500 mt-2">
                                                    Created {{ $transaction->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions Row -->
                                    <div class="flex flex-wrap gap-2 md:flex-col md:items-end">
                                        @if ($transaction->status === 'pending' && $transaction->seller_id === auth()->id())
                                            <a href="{{ route('transaction.links', $transaction->id) }}"
                                               class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 border border-blue-600 text-xs font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="h-3 sm:h-4 w-3 sm:w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                View Links
                                            </a>
                                        @endif

                                        @if ($transaction->status === 'completed')
                                            <a href="{{ route('transaction.report', $transaction->id) }}"
                                               class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 border border-emerald-600 text-xs font-medium rounded-md text-emerald-600 bg-white hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                <svg class="h-3 sm:h-4 w-3 sm:w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                View Report
                                            </a>
                                        @endif

                                        <a href="{{ route('items.view', $transaction->item->slug) }}"
                                           class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View Item
                                        </a>

                                        @if ($transaction->status === 'pending' && $transaction->seller_id === auth()->id())
                                            <form method="POST" action="{{ route('transaction.cancel', $transaction->id) }}"
                                                  onsubmit="return confirm('Are you sure you want to cancel this transaction?');">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 border border-red-300 text-xs font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <div class="mt-4 sm:mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
