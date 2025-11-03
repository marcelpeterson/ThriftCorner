@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manage News</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-600">Create and manage blog articles</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-md transition-colors text-center">
            + Create Article
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-3 sm:p-4">
            <div class="flex gap-3">
                <svg class="h-5 w-5 text-green-400 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs sm:text-sm text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Articles Table (Desktop) --}}
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700">Thumbnail</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700">Title</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700">Author</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-700">Created At</th>
                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($articles as $article)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 sm:px-6 py-4">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="Thumbnail" class="w-full h-16 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                <span class="text-xs text-gray-400">No image</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <p class="text-sm font-medium text-gray-900">{{ $article->title }}</p>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $article->user->first_name }} {{ $article->user->last_name }}</p>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $article->created_at->format('d M Y') }}</p>
                    </td>
                    <td class="px-4 sm:px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.news.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                            <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium cursor-pointer">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 sm:px-6 py-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 text-sm font-medium">No news articles found</p>
                        <p class="text-gray-400 text-xs mt-1">Create your first article to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Articles Cards (Mobile) --}}
    <div class="md:hidden space-y-3">
        @forelse($articles as $article)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex gap-3">
                @if($article->thumbnail)
                    <img src="{{ Storage::url($article->thumbnail) }}" alt="Thumbnail" class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                @else
                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $article->title }}</h3>
                    <div class="flex justify-between">
                        <p class="text-xs text-gray-600 mt-1">By {{ $article->user->first_name }} {{ $article->user->last_name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('admin.news.edit', $article) }}" class="flex-1 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-medium hover:bg-indigo-100 transition-colors text-center">Edit</a>
                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this article?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-1.5 bg-red-50 text-red-600 rounded text-xs font-medium hover:bg-red-100 transition-colors">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-500 text-sm font-medium mt-2">No news articles found</p>
            <p class="text-gray-400 text-xs mt-1">Create your first article to get started</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection