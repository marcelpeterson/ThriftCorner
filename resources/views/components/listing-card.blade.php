@props(['item'])

<a href="{{ route('items.view', $item->id) }}" class="block rounded-lg border border-gray-200 bg-white p-6 hover:shadow-lg transition-shadow duration-200 ease-in-out">
    <div class="flex items-center gap-0.5">
        <img src="{{ $item->user->photo_url }}" alt="User photo from API" class="w-10 h-10 rounded-full object-cover inline-block">
        <div>
            <p class="text-sm font-medium text-gray-900 inline-block ml-2">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
            <p class="text-xs text-gray-500 ml-2">{{ $item->created_at->diffForHumans() }}</p>
        </div>
    </div>
    @if($item->images->isNotEmpty())
        <img src="{{ Storage::url($item->images->first()->image_path) }}" alt="{{ $item->name }}" class="mt-3 w-96 h-96 object-cover rounded-md">
    @else
        <div class="mt-4 w-full h-48 bg-gray-100 flex items-center justify-center rounded-md">
            <span class="text-gray-400">No Image</span>
        </div>
    @endif
    <div>
        <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $item->name }}</h3>
        <p class="mt-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
        <div class="mt-2 flex items-center justify-between">
            <p class="text-md font-semibold text-gray-900">{{ $item->price_rupiah }}</p>
            <div class="inline-flex items-center mt-1">
                <svg class="w-5 h-5 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-blue-800 font-semibold mt-[-2px]">{{ $item->condition }}</span>
            </div>
        </div>
    </div>
</a>
