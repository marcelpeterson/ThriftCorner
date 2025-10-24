@extends('layouts.app')

@section('title', 'Admin Dashboard - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Monitor and manage ThriftCorner platform</p>
        </div>
        <div class="flex flex-wrap gap-2 sm:gap-3 items-center w-full sm:w-auto">
            {{-- Disabled Google Analytics button in favor of SimpleAnalytics --}}
            {{--
            <a href="{{ route('admin.analytics') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="align-middle">
                    Analytics
                </span>
            </a>
            --}}
            <a href="{{ route('admin.support.index') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-1 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>
                    Support
                </span>
            </a>
            <a href="{{ route('admin.news.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h4l2 3h6l2-3h4a2 2 0 012 2v12a2 2 0 01-2 2zM7 10h10M7 14h6m-6 4h4"/>
                </svg>
                <span class="align-middle">
                    Manage News
                </span>
            </a>
        </div>
    </div>

    {{-- Key Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Users --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Listings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Listings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_listings']) }}</p>
                    <p class="text-sm text-green-600 mt-1">{{ number_format($stats['active_listings']) }} active</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Sold Items --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sold Items</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['sold_listings']) }}</p>
                    @if($stats['total_listings'] > 0)
                        <p class="text-sm text-gray-500 mt-1">{{ number_format(($stats['sold_listings'] / $stats['total_listings']) * 100, 1) }}% conversion</p>
                    @endif
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ rupiah($totalRevenue) }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ number_format($stats['total_transactions']) }} transactions</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Google Analytics Overview (disabled in favor of SimpleAnalytics) --}}
    {{--
    @if($analyticsData)
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Google Analytics - Last 30 Days
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-blue-100 text-sm">Total Visitors</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($analyticsData['visitors']->sum('activeUsers')) }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Page Views</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($analyticsData['pageViews']->sum('screenPageViews')) }}</p>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Device Types</p>
                    @if(count($analyticsData['deviceTypes']) === 0)
                        <p class="text-sm font-bold mt-2">No data available</p>
                    @else
                        <p class="text-sm mt-2">
                            @foreach($analyticsData['deviceTypes'] as $device)
                                <span class="inline-block bg-blue-500 px-2 py-1 rounded text-xs mr-1">{{ $device['deviceCategory'] }}: {{ $device['activeUsers'] }}</span>
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif
    --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Category Distribution --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Listings by Category</h3>
            <div class="space-y-3">
                @foreach($categoryStats as $category)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $category['name'] }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $category['total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ ($category['total'] / $stats['total_listings']) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Monthly Revenue Trend --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Monthly Revenue (Last 6 Months)</h3>
            <div class="space-y-3">
                @if($monthlyRevenue->isEmpty())
                    <p class="text-sm font-bold text-gray-500">No revenue data available</p>
                @else
                    @foreach($monthlyRevenue as $month)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</span>
                                <span class="text-sm font-bold text-emerald-600">{{ rupiah($month->revenue) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($month->revenue / $monthlyRevenue->max('revenue')) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Users --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Recent Users</h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                    <div class="flex items-center gap-3">
                        @if($user->photo_url)
                            <img src="{{ $user->photo_url }}" alt="{{ $user->first_name }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-sm">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->full_name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Listings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Recent Listings</h3>
                <a href="{{ route('admin.listings') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentListings as $listing)
                    <div class="flex items-start gap-3">
                        @if($listing->images->count() > 0)
                            <img src="{{ Storage::url($listing->images->first()->image_path) }}" alt="{{ $listing->name }}" class="w-12 h-12 rounded object-cover">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $listing->name }}</p>
                            <p class="text-xs text-emerald-600 font-semibold">{{ $listing->price_rupiah }}</p>
                            <p class="text-xs text-gray-500">by {{ $listing->user->first_name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                <a href="{{ route('admin.transactions') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentTransactions as $transaction)
                    <div class="border-l-4 border-green-500 pl-3">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $transaction->item->name }}</p>
                        <p class="text-xs text-gray-600">{{ $transaction->seller->first_name }} → {{ $transaction->buyer->first_name }}</p>
                        <p class="text-xs text-green-600 font-semibold">{{ $transaction->item->price_rupiah }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->completed_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No completed transactions yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
