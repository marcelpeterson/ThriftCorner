@props(['item'])

<div class="rounded-lg border border-gray-200 bg-white p-6">
    <div class="flex items-center gap-0.5">
        <img src="{{ $item->user->photo_url }}" alt="User photo from API" class="w-10 h-10 rounded-full object-cover inline-block">
        <div>
            <p class="text-sm font-medium text-gray-900 inline-block ml-2">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
            <p class="text-xs text-gray-500 ml-2">{{ $item->created_at->diffForHumans() }}</p>
        </div>
    </div>
    @if($item->photo_url)
        <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="mt-3 w-96 h-96 object-cover rounded-md">
    @else
        <div class="mt-4 w-full h-48 bg-gray-100 flex items-center justify-center rounded-md">
            <span class="text-gray-400">No Image</span>
        </div>
    @endif
    <div>
        <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $item->name }}</h3>
        <p class="mt-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
        <p class="mt-2 text-md font-semibold text-gray-900">{{ $item->price_rupiah }}</p>
        <p class="mt-1 text-sm text-gray-600">{{ $item->condition }}</p>
    </div>
</div>
