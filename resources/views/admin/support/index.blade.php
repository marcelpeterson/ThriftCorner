@extends('layouts.app')

@section('title', 'Support Submissions - Admin - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Support Submissions</h1>
            <p class="text-sm text-gray-600 mt-1">Manage user reports and feedback</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors text-sm flex flex-row items-center max-md:hidden">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-2 sm:gap-4 border-b border-gray-200 overflow-x-auto">
        <a href="{{ route('admin.support.index') }}" class="px-3 sm:px-4 py-2 border-b-2 text-xs sm:text-sm whitespace-nowrap {{ !request('status') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
            All ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.support.index', ['status' => 'pending']) }}" class="px-3 sm:px-4 py-2 border-b-2 text-xs sm:text-sm whitespace-nowrap {{ request('status') === 'pending' ? 'border-yellow-600 text-yellow-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
            Pending ({{ $stats['pending'] }})
        </a>
        <a href="{{ route('admin.support.index', ['status' => 'in_progress']) }}" class="px-3 sm:px-4 py-2 border-b-2 text-xs sm:text-sm whitespace-nowrap {{ request('status') === 'in_progress' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
            In Progress ({{ $stats['in_progress'] }})
        </a>
        <a href="{{ route('admin.support.index', ['status' => 'resolved']) }}" class="px-3 sm:px-4 py-2 border-b-2 text-xs sm:text-sm whitespace-nowrap {{ request('status') === 'resolved' ? 'border-green-600 text-green-600 font-semibold' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
            Resolved ({{ $stats['resolved'] }})
        </a>
    </div>

    {{-- Filter by Type --}}
    <div class="flex flex-wrap gap-2 sm:gap-3">
        <a href="{{ route('admin.support.index', array_merge(request()->except('type'), request('status') ? ['status' => request('status')] : [])) }}" class="px-3 sm:px-4 py-2 rounded-lg text-sm {{ !request('type') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors whitespace-nowrap">
            All Types
        </a>
        <a href="{{ route('admin.support.index', array_merge(['type' => 'report_suspicious'], request('status') ? ['status' => request('status')] : [])) }}" class="px-3 sm:px-4 py-2 rounded-lg text-sm {{ request('type') === 'report_suspicious' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            Reports
        </a>
        <a href="{{ route('admin.support.index', array_merge(['type' => 'feedback'], request('status') ? ['status' => request('status')] : [])) }}" class="px-3 sm:px-4 py-2 rounded-lg text-sm {{ request('type') === 'feedback' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            Feedback
        </a>
        <a href="{{ route('admin.support.index', array_merge(['type' => 'delete_listing'], request('status') ? ['status' => request('status')] : [])) }}" class="px-3 sm:px-4 py-2 rounded-lg text-sm {{ request('type') === 'delete_listing' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Deletion Requests
        </a>
    </div>

    {{-- Submissions List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @forelse($submissions as $submission)
            <div class="border-b border-gray-200 last:border-b-0 hover:bg-gray-50 transition-colors">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                        <div class="flex-1 min-w-0 w-full">
                            <div class="flex items-center gap-3 mb-2 flex-wrap">
                                {{-- Type Badge --}}
                                @if($submission->type === 'report_suspicious')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Report
                                    </span>
                                @elseif($submission->type === 'delete_listing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete Request
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Feedback
                                    </span>
                                @endif

                                {{-- Status Badge --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $submission->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $submission->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $submission->status_label }}
                                </span>

                                <span class="text-xs sm:text-sm text-gray-500">•</span>
                                <span class="text-xs sm:text-sm text-gray-500">{{ $submission->created_at->diffForHumans() }}</span>
                            </div>

                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ $submission->subject }}</h3>

                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 text-xs sm:text-sm text-gray-600 mb-3">
                                <span class="font-medium">From:</span>
                                <span>{{ $submission->name }}</span>
                                <span class="text-gray-400 hidden sm:inline">•</span>
                                <a href="mailto:{{ $submission->email }}" class="text-blue-600 hover:text-blue-800 truncate">{{ $submission->email }}</a>
                                @if($submission->user)
                                    <span class="text-gray-400 hidden sm:inline">•</span>
                                    <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800">View User</a>
                                @endif
                            </div>

                            <p class="text-gray-700 mb-3 line-clamp-2 text-sm">{{ $submission->message }}</p>

                            @if($submission->attachment_path)
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    <a href="{{ Storage::url($submission->attachment_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Attachment
                                    </a>
                                </div>
                            @endif

                            @if($submission->admin_notes)
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-1">Admin Notes:</p>
                                    <p class="text-xs sm:text-sm text-gray-600">{{ $submission->admin_notes }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-row sm:flex-col gap-2 w-full sm:w-auto">
                            <a href="{{ route('admin.support.show', $submission) }}" class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors text-center">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">No submissions found</p>
                <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($submissions->hasPages())
        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    @endif
</div>
@endsection
