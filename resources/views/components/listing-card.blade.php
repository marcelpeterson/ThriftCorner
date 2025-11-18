@props(['item', 'featured' => false])

<a href="{{ route('items.view', $item->slug) }}"
   class="group block rounded-lg border {{ $item->isPremium() ? 'border-purple-300 bg-gradient-to-br from-purple-50 to-blue-50 ring-2 ring-purple-200' : 'border-gray-200 bg-white' }} p-6 hover:shadow-xl transition-all duration-200 ease-in-out {{ $item->isPremium() ? 'transform hover:scale-105' : '' }}">
    
    @if($item->isPremium())
        <div class="absolute -top-3 -right-3 z-10 hidden md:block md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200">
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-xs font-bold">FEATURED</span>
            </div>
        </div>
    @endif

    <div class="flex items-center gap-0.5 max-md:gap-0.25">
        @if($item->user->photo)
            <img src="{{ $item->user->photo }}" alt="{{ $item->user->first_name }}" class="w-10 h-10 max-md:w-9 max-md:h-9 rounded-full object-cover inline-block">
        @else
            <img src="{{ Avatar::create($item->user->first_name . ' ' . $item->user->last_name)->toBase64() }}"
                 alt="{{ $item->user->first_name }}" class="w-10 h-10 max-md:w-9 max-md:h-9 rounded-full object-cover inline-block">
        @endif
        <div class="flex flex-col sm:gap-0.5">
            <p class="text-sm font-medium text-gray-900 inline-block ml-2">{{ $item->user->first_name }}</p>
            <p class="text-xs text-gray-500 ml-2">{{ $item->created_at->diffForHumans() }}</p>
        </div>
    </div>
    @if($item->images->isNotEmpty())
        <div class="relative mt-3 w-full">
            <img src="{{ Storage::url($item->images->first()->image_path) }}" alt="{{ $item->name }}" class="w-full aspect-square object-cover rounded-md {{ $item->isPremium() ? 'ring-2 ring-purple-300' : '' }}">
        </div>
    @else
        <div class="mt-4 w-full aspect-square bg-gray-100 flex items-center justify-center rounded-md">
            <span class="text-gray-400">No Image</span>
        </div>
    @endif
    <div>
        <h3 class="text-lg font-bold {{ $item->isPremium() ? 'text-purple-900' : 'text-gray-900' }} mt-2 sm:hidden">{{ \Illuminate\Support\Str::limit($item->name, 10) }}</h3>
        <h3 class="text-lg font-bold {{ $item->isPremium() ? 'text-purple-900' : 'text-gray-900' }} mt-2 max-sm:hidden">{{ $item->name }}</h3>
        <p class="mt-1 text-sm {{ $item->isPremium() ? 'text-gray-700' : 'text-gray-600' }}">{{ \Illuminate\Support\Str::limit($item->description, 50) }}</p>
        <div class="mt-2 max-md:mt-3 max-md:flex-col max-md:items-start flex items-center justify-between">
            <p class="text-md font-semibold max-md:font-bold {{ $item->isPremium() ? 'text-purple-700' : 'text-gray-900' }}">{{ $item->price_rupiah }}</p>
            <div class="inline-flex items-center mt-1 flex-row-reverse md:flex-row">
            <svg
                class="w-5 h-5 ml-0.75 max-md:mb-0.75 md:ml-0 md:mr-1.5 {{ $item->isPremium() ? 'text-purple-600' : 'text-blue-600' }}"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            <span class="{{ $item->isPremium() ? 'text-purple-800' : 'text-blue-800' }} font-semibold mt-[-2px]">
                {{ $item->condition }}
            </span>
            </div>
        </div>
    </div>
</a>
