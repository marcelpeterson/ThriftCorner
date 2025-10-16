@extends('layouts.app')

@section('title', 'Support Submission #' . $submission->id . ' - Admin - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Support Submission #{{ $submission->id }}</h1>
            <p class="text-gray-600 mt-1">{{ $submission->type_label }}</p>
        </div>
        <a href="{{ route('admin.support.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Submission Details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        @if($submission->type === 'report_suspicious')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Suspicious Activity Report
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                User Feedback
                            </span>
                        @endif
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $submission->subject }}</h2>
                    <p class="text-sm text-gray-500">Submitted {{ $submission->created_at->format('F j, Y g:i A') }}</p>
                </div>

                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Message</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->message }}</p>
                    </div>
                </div>

                @if($submission->attachment_path)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Attachment</h3>
                        <div class="border border-gray-200 rounded-lg p-4">
                            @php
                                $extension = pathinfo($submission->attachment_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp

                            @if($isImage)
                                <img src="{{ Storage::url($submission->attachment_path) }}" alt="Attachment" class="max-w-full rounded-lg mb-3">
                            @endif

                            <a href="{{ Storage::url($submission->attachment_path) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                Download Attachment
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Admin Notes --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h3>
                <form action="{{ route('admin.support.update-notes', $submission) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea name="admin_notes" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add internal notes about this submission...">{{ $submission->admin_notes }}</textarea>
                    <div class="flex justify-end mt-3">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                            Save Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Submitter Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Submitter Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="text-gray-900">{{ $submission->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <a href="mailto:{{ $submission->email }}" class="text-blue-600 hover:text-blue-800">{{ $submission->email }}</a>
                    </div>
                    @if($submission->user)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registered User</p>
                            <div class="flex items-center gap-2 mt-1">
                                @if($submission->user->photo_url)
                                    <img src="{{ $submission->user->photo_url }}" alt="{{ $submission->user->first_name }}" class="w-8 h-8 rounded-full object-cover">
                                @endif
                                <div>
                                    <p class="text-gray-900 font-medium">{{ $submission->user->full_name }}</p>
                                    <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:text-blue-800">View User Profile</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>
                            <p class="text-sm font-medium text-gray-500">Account Status</p>
                            <p class="text-gray-600">Guest Submission</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Status Management --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <form action="{{ route('admin.support.update-status', $submission) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-3">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $submission->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $submission->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}">
                                Current: {{ $submission->status_label }}
                            </span>
                        </div>
                        <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $submission->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $submission->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="mailto:{{ $submission->email }}" class="block w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Reply via Email
                    </a>
                    <form action="{{ route('admin.support.destroy', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Submission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
