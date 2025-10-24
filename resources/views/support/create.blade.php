@extends('layouts.app')

@section('title', 'Contact Support - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto max-md:mt-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Contact Support</h1>
            <p class="text-gray-600 mt-2">Report suspicious activity or share your feedback to help us improve ThriftCorner.</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4" x-data="{ show: true }" x-show="show" x-transition>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Support Form --}}
        <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Contact Type --}}
            <div class="mb-6">
                <label for="type" class="block text-sm font-semibold text-gray-900 mb-2">What can we help you with?</label>
                <select name="type" id="type" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                    <option value="">Select an option</option>
                    <option value="report_suspicious" {{ old('type') === 'report_suspicious' ? 'selected' : '' }}>Report Suspicious Activity</option>
                    <option value="feedback" {{ old('type') === 'feedback' ? 'selected' : '' }}>General Feedback</option>
                    <option value="delete_listing" {{ old('type') === 'delete_listing' ? 'selected' : '' }}>Request Listing Deletion</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Item Selection (for delete_listing requests) --}}
            <div class="mb-6" id="item-selection" style="display: none;">
                <label for="item_id" class="block text-sm font-semibold text-gray-900 mb-2">Select the Listing to Delete</label>
                <select name="item_id" id="item_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('item_id') border-red-500 @enderror">
                    <option value="">Select a listing</option>
                    @forelse(Auth::user()?->items ?? [] as $item)
                        <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }}
                        </option>
                    @empty
                        <option value="" disabled>You don't have any active listings</option>
                    @endforelse
                </select>
                @error('item_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Name (only for guests) --}}
            @guest
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Your Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Your Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endguest

            {{-- Subject --}}
            <div class="mb-6">
                <label for="subject" class="block text-sm font-semibold text-gray-900 mb-2">Subject</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required maxlength="255" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror" placeholder="Brief description of your concern">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Message --}}
            <div class="mb-6">
                <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">Message</label>
                <textarea name="message" id="message" rows="6" required maxlength="5000" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror" placeholder="Please provide detailed information about your report or feedback">{{ old('message') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Maximum 5000 characters</p>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Attachment --}}
            <div class="mb-6">
                <label for="attachment" class="block text-sm font-semibold text-gray-900 mb-2">Attachment (Optional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="attachment" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Upload a file</span>
                                <input id="attachment" name="attachment" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">JPG, PNG, PDF, DOC up to 5MB</p>
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">Attach screenshots, photos, or documents as evidence</p>
                @error('attachment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end gap-4">
                <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors cursor-pointer">
                    Submit
                </button>
            </div>
        </form>
    </div>

    {{-- Info Boxes --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-red-50 rounded-lg border border-red-200 p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="font-bold text-red-900 mb-2">Report Suspicious Activity</h3>
                    <p class="text-sm text-red-800">Found suspicious users, scams, or fraudulent listings? Report them here with evidence to help keep our community safe.</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <div>
                    <h3 class="font-bold text-blue-900 mb-2">General Feedback</h3>
                    <p class="text-sm text-blue-800">Have suggestions or ideas to improve ThriftCorner? We'd love to hear from you! Your feedback helps us build a better platform.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const typeSelect = document.getElementById('type');
    const itemSelection = document.getElementById('item-selection');
    const itemInput = document.getElementById('item_id');

    // Show/hide item selection based on type
    function toggleItemSelection() {
        if (typeSelect.value === 'delete_listing') {
            itemSelection.style.display = 'block';
            itemInput.required = true;
        } else {
            itemSelection.style.display = 'none';
            itemInput.required = false;
        }
    }

    typeSelect.addEventListener('change', toggleItemSelection);

    // Initial state
    toggleItemSelection();

    // Show selected file name
    document.getElementById('attachment').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const label = e.target.previousElementSibling;
            label.textContent = fileName;
        }
    });
</script>
@endpush
@endsection
