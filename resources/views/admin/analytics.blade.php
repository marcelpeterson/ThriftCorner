@extends('layouts.app')

@section('title', 'Analytics - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Google Analytics</h1>
            <p class="text-gray-600 mt-1">Website traffic and user behavior insights</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
            ← Back to Dashboard
        </a>
    </div>

    {{-- Period Selector --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.analytics') }}" class="flex items-center gap-4">
            <label for="period" class="text-sm font-medium text-gray-700">Time Period:</label>
            <select name="period" id="period" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 days</option>
                <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 days</option>
                <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 days</option>
            </select>
        </form>
    </div>

    @if(session('analytics_error'))
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-amber-800">Analytics Configuration Issue</h3>
                    <p class="text-sm text-amber-700 mt-1">{{ session('analytics_error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(!$analyticsData)
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
            <svg class="w-16 h-16 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Google Analytics Not Configured</h3>
            <p class="text-gray-600 mb-6">To view analytics data, you need to configure Google Analytics credentials.</p>
            
            <div class="bg-white rounded-lg p-6 text-left max-w-2xl mx-auto">
                <h4 class="font-bold text-gray-900 mb-3">Setup Instructions:</h4>
                <ol class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="font-bold mr-2">1.</span>
                        <span>Create a Google Analytics 4 property for your website</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">2.</span>
                        <span>Create a service account in Google Cloud Console</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">3.</span>
                        <span>Download the JSON credentials file</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">4.</span>
                        <span>Place the file in <code class="bg-gray-100 px-2 py-1 rounded">storage/app/analytics/</code></span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">5.</span>
                        <span>Update <code class="bg-gray-100 px-2 py-1 rounded">config/analytics.php</code> with your property ID</span>
                    </li>
                </ol>
            </div>
        </div>
    @else
        {{-- Overview Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-600">Total Visitors</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($analyticsData['totalVisitors']->sum('activeUsers')) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-600">Page Views</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($analyticsData['totalPageViews']->sum('screenPageViews')) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-600">Sessions</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($analyticsData['totalSessions']->sum('sessions')) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-600">Avg Session Duration</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($analyticsData['avgSessionDuration']->avg('averageSessionDuration'), 0) }}s</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-600">Bounce Rate</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($analyticsData['bounceRate']->avg('bounceRate'), 1) }}%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Top Pages --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Top Pages</h3>
                <div class="space-y-3">
                    @foreach($analyticsData['topPages']->take(10) as $page)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700 truncate flex-1">{{ $page['pageTitle'] }}</span>
                                <span class="text-sm font-bold text-gray-900 ml-2">{{ number_format($page['screenPageViews']) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $page['fullPageUrl'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Traffic Sources --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Traffic Sources</h3>
                <div class="space-y-3">
                    @foreach($analyticsData['trafficSources']->take(10) as $source)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $source['sessionSource'] }}</p>
                                <p class="text-xs text-gray-500">{{ $source['sessionMedium'] }}</p>
                            </div>
                            <span class="text-sm font-bold text-emerald-600">{{ number_format($source['activeUsers']) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Device Types --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Device Types</h3>
                <div class="space-y-4">
                    @foreach($analyticsData['deviceTypes'] as $device)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $device['deviceCategory'] }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ number_format($device['activeUsers']) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full" style="width: {{ ($device['activeUsers'] / $analyticsData['deviceTypes']->sum('activeUsers')) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Top Countries --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Top Countries</h3>
                <div class="space-y-3">
                    @foreach($analyticsData['topCountries']->take(10) as $country)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $country['country'] }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($country['activeUsers']) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Daily Visitors Chart --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daily Visitors Trend</h3>
            @if($analyticsData['dailyVisitors']->isNotEmpty())
                <div class="h-64 flex items-end justify-between gap-1">
                    @foreach($analyticsData['dailyVisitors'] as $day)
                        <div class="flex-1 bg-blue-500 hover:bg-blue-600 transition-colors rounded-t" 
                             style="height: {{ ($day['activeUsers'] / $analyticsData['dailyVisitors']->max('activeUsers')) * 100 }}%"
                             title="{{ $day['date'] }}: {{ $day['activeUsers'] }} visitors">
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span>{{ $analyticsData['dailyVisitors']->first()['date'] }}</span>
                    <span>{{ $analyticsData['dailyVisitors']->last()['date'] }}</span>
                </div>
            @else
                <div class="h-64 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-sm">No visitor data available for this period</p>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
