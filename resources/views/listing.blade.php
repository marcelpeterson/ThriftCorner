@extends('layouts.app')

@section('title', $item->name . ' - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 max-md:mt-2">
    {{-- Back Button --}}
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center text-xs sm:text-sm text-gray-600 hover:text-gray-700 font-medium">
            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Listings
        </a>
    </div>

    {{-- Image Carousel --}}
    <div class="mb-6 sm:mb-8">
        @if($item->images->count() > 0)
            <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ $item->images->count() }} }">
                {{-- Main Image Display --}}
                <div class="relative w-full h-[250px] sm:h-[300px] md:h-[400px] rounded-xl sm:rounded-2xl shadow-lg overflow-hidden">
                    @foreach($item->images as $index => $image)
                        <div class="absolute inset-0 transition-opacity duration-300"
                             :class="currentSlide === {{ $index }} ? 'opacity-100' : 'opacity-0'">
                            {{-- Blurred Background --}}
                            <div class="absolute inset-0">
                                <img src="{{ Storage::url($image->image_path) }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                            </div>
                            {{-- Actual Image --}}
                            <img src="{{ Storage::url($image->image_path) }}"
                                 alt="{{ $item->name }} - Image {{ $index + 1 }}"
                                 class="relative w-full h-full object-contain z-10">
                        </div>
                    @endforeach

                    {{-- Navigation Arrows (only show if more than 1 image) --}}
                    @if($item->images->count() > 1)
                        <button @click="currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1"
                                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 sm:p-2 transition-colors z-20 cursor-pointer">
                            <svg class="w-4 sm:w-6 h-4 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1"
                                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 sm:p-2 transition-colors z-20 cursor-pointer">
                            <svg class="w-4 sm:w-6 h-4 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        {{-- Slide Indicators --}}
                        <div class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex gap-1 sm:gap-2 z-20">
                            @foreach($item->images as $index => $image)
                                <button @click="currentSlide = {{ $index }}"
                                        class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full transition-all"
                                        :class="currentSlide === {{ $index }} ? 'bg-white w-6 sm:w-8' : 'bg-white/50'">
                                </button>
                            @endforeach
                        </div>

                        {{-- Image Counter --}}
                        <div class="absolute top-2 sm:top-4 right-2 sm:right-4 bg-black/50 text-white px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium z-20">
                            <span x-text="currentSlide + 1"></span> / {{ $item->images->count() }}
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Strip (only show if more than 1 image) --}}
                @if($item->images->count() > 1)
                    <div class="mt-3 sm:mt-4 flex gap-2 overflow-x-auto pb-2">
                        @foreach($item->images as $index => $image)
                            <button @click="currentSlide = {{ $index }}"
                                    class="flex-shrink-0 w-16 sm:w-20 h-16 sm:h-20 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="currentSlide === {{ $index }} ? 'border-emerald-600 ring-2 ring-emerald-200' : 'border-gray-200 hover:border-gray-300'">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @elseif($item->photo)
            {{-- Fallback to old single photo --}}
            <div class="relative w-full h-[250px] sm:h-[300px] md:h-[400px] rounded-xl sm:rounded-2xl shadow-lg overflow-hidden">
                <div class="absolute inset-0">
                    <img src="{{ $item->photo }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                </div>
                <img src="{{ $item->photo }}" alt="{{ $item->name }}" class="relative w-full h-full object-contain z-10">
            </div>
        @else
            {{-- No images available --}}
            <div class="w-full h-[250px] sm:h-[300px] md:h-[400px] bg-gray-200 flex items-center justify-center rounded-xl sm:rounded-2xl shadow-lg">
                <div class="text-center">
                    <svg class="w-16 sm:w-24 h-16 sm:h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 font-medium">No Image Available</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Disclaimer Modal --}}
    <div id="disclaimerModal" class="hidden fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            {{-- Modal Header --}}
            <div class="sticky top-0 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-200 px-6 py-4 flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Important Notice</h3>
                        <p class="text-xs text-gray-600 mt-1">Before contacting the seller</p>
                    </div>
                </div>
                <button onclick="closeDisclaimerModal()"
                        type="button"
                        class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 cursor-pointer mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-6 py-6 space-y-5">
                {{-- Main Disclaimer Message --}}
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                    <p class="text-sm text-gray-800 font-semibold mb-2">⚠ Off-Platform Transactions</p>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Transactions that occur outside this platform are <span class="font-bold">not our responsibility</span>. We provide a marketplace for connecting buyers and sellers, but all negotiations, payment, and delivery arrangements are between you and the seller.
                    </p>
                </div>

                {{-- Security Tips Section --}}
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        How to Make a Secure Transaction
                    </h4>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">1</span>
                            <span class="text-gray-700"><span class="font-semibold">Meet in Safe Locations</span> — Always meet in public places (mall, cafe, office) during daytime when possible.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">2</span>
                            <span class="text-gray-700"><span class="font-semibold">Inspect Thoroughly</span> — Examine the item closely before making payment. Check for damage, defects, or missing parts.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">3</span>
                            <span class="text-gray-700"><span class="font-semibold">Verify Item Authenticity</span> — For electronics/branded items, check serial numbers and authenticity markers.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">4</span>
                            <span class="text-gray-700"><span class="font-semibold">Use Secure Payment</span> — Prefer cash or verified payment methods. Avoid wire transfers to unknown accounts.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">5</span>
                            <span class="text-gray-700"><span class="font-semibold">Never Share Sensitive Info</span> — Don't provide bank details, passwords, or personal documents unless absolutely necessary.</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">6</span>
                            <span class="text-gray-700"><span class="font-semibold">Bring a Friend</span> — Consider bringing a trusted friend to the meetup for added safety and perspective.</span>
                        </li>
                    </ul>
                </div>

                {{-- What to Avoid Section --}}
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center text-red-700">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        ❌ Avoid These Red Flags
                    </h4>
                    <ul class="space-y-1 text-sm text-gray-700 ml-2">
                        <li>• Sellers who pressure you to pay before inspection</li>
                        <li>• Requests to send payment via untraceable methods</li>
                        <li>• Unusually low prices compared to market value</li>
                        <li>• Sellers unwilling to meet in person</li>
                        <li>• Requests for personal info beyond necessity</li>
                    </ul>
                </div>

                {{-- Acknowledgment Section --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox"
                               id="disclaimerCheckbox"
                               class="w-4 h-4 mt-1 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">
                            I understand that <span class="font-semibold">transactions outside this platform are not our responsibility</span>, and I will follow the security tips above.
                        </span>
                    </label>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex gap-3 justify-end">
                <button onclick="closeDisclaimerModal()"
                        type="button"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors font-medium cursor-pointer">
                    Cancel
                </button>
                <button onclick="proceedToWhatsApp()"
                        id="proceedButton"
                        type="button"
                        class="px-6 py-2 rounded-lg transition-colors font-medium inline-flex items-center gap-2 bg-gray-300 text-gray-500 cursor-not-allowed opacity-60 disabled:hover:bg-gray-300"
                        disabled>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Proceed to WhatsApp
                </button>
            </div>
        </div>
    </div>

    {{-- Deletion Request Modal --}}
    <div id="deletionRequestModal" class="hidden fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200 px-4 sm:px-6 py-3 sm:py-4 rounded-t-xl sm:rounded-t-2xl">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Request Listing Deletion</h3>
                            <p class="text-xs text-gray-600 mt-1">Submit a support ticket to delete your listing</p>
                        </div>
                    </div>
                    <button onclick="closeDeletionRequestModal()"
                            type="button"
                            class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 cursor-pointer mt-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="delete_listing">
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="subject" value="Deletion Request: {{ $item->name }} (ID: {{ $item->id }})">
                
                <div class="px-4 sm:px-6 py-6 space-y-5">
                    {{-- Item Information --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Item to be deleted:</h4>
                        <div class="flex items-center gap-3">
                            @if($item->images->count() > 0)
                                <img src="{{ Storage::url($item->images->first()->image_path) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @elseif($item->photo)
                                <img src="{{ $item->photo }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->price_rupiah }}</p>
                                <p class="text-xs text-gray-500">Listed {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Reason for Deletion --}}
                    <div>
                        <label for="deletion_reason" class="block text-sm font-semibold text-gray-900 mb-2">
                            Reason for Deletion <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" id="deletion_reason" rows="4" required maxlength="5000"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Please explain why you want to delete this listing..."></textarea>
                        <p class="mt-1 text-sm text-gray-500">Maximum 5000 characters</p>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <h4 class="font-semibold text-amber-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Important Notice
                        </h4>
                        <p class="text-sm text-amber-800">
                            {{-- Once you submit this request, our admin team will review it. The deletion will be processed after verification, and you'll receive a notification when completed. This action cannot be undone. --}}
                            Once you submit this request, our admin team will review it. The deletion will be processed after verification. This action cannot be undone.
                        </p>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 rounded-b-xl sm:rounded-b-2xl flex gap-3 justify-end max-md:justify-between border-t border-gray-200">
                    <button type="button" onclick="closeDeletionRequestModal()"
                            class="px-4 py-2 text-gray-700 max-md:text-sm bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors font-medium cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white max-md:text-sm font-semibold rounded-lg transition-colors cursor-pointer">
                        Submit Deletion Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        {{-- Left Column: Item Details --}}
        <div class="lg:col-span-2">
            {{-- Item Name with Premium Badge --}}
            <div class="flex flex-row sm:items-start sm:justify-between sm:gap-3 mb-1 sm:mb-3">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold max-md:font-black text-gray-900 flex-1">{{ $item->name }}</h1>
                @if($item->isPremium())
                    <div class="flex-shrink-0 mt-1">
                        <div class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full shadow-md whitespace-nowrap text-xs sm:text-sm">
                            <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1 sm:mr-1.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-white font-bold">PREMIUM</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Price --}}
            <div class="mb-4 sm:mb-6">
                <p class="text-2xl sm:text-3xl font-bold text-blue-500 max-md:font-black">{{ $item->price_rupiah }}</p>
            </div>

            {{-- Condition --}}
            <div class="mb-6 sm:mb-8">
                <div class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-50 rounded-full text-sm">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-blue-800 font-semibold">Condition: {{ $item->condition }}</span>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-6 sm:mb-8">
                <h2 class="text-xl max-md:font-black sm:text-2xl font-bold text-gray-900 mb-2">Description</h2>
                <div class="prose prose-sm sm:prose max-w-none">
                    @if($item->description)
                        <p class="text-sm sm:text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->description }}</p>
                    @else
                        <p class="text-sm sm:text-sm text-gray-500 italic">No description provided.</p>
                    @endif
                </div>
            </div>

            {{-- Additional Details --}}
            <div class="bg-gray-50 rounded-lg max-md:mb-2">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2">Item Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Category</p>
                        <p class="font-semibold text-xs sm:text-sm text-gray-900">{{ $item->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Listed</p>
                        <p class="font-semibold text-xs sm:text-sm text-gray-900">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Last Updated</p>
                        <p class="font-semibold text-xs sm:text-sm text-gray-900">{{ $item->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">Condition</p>
                        <p class="font-semibold text-xs sm:text-sm text-gray-900">{{ $item->condition }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Seller Info & Actions --}}
        <div class="lg:col-span-1">
            <div class="lg:sticky lg:top-8">
                {{-- Seller Card --}}
                <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm mb-4 max-md:mb-0">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4">Seller Information</h3>

                    <div class="flex items-center mb-4">
                        @if($item->user->photo)
                            <img src="{{ $item->user->photo }}" alt="{{ $item->user->first_name }}" class="w-12 sm:w-16 h-12 sm:h-16 rounded-full object-cover">
                        @else
                            <img src="{{ Avatar::create($item->user->first_name . ' ' . $item->user->last_name)->toBase64() }}"
                                 alt="{{ $item->user->first_name }}" class="w-12 sm:w-16 h-12 sm:h-16 rounded-full object-cover">
                        @endif
                            <div class="w-12 sm:w-16 h-12 sm:h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-600 font-bold text-lg sm:text-xl">{{ substr($item->user->first_name, 0, 1) }}{{ substr($item->user->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ml-3 sm:ml-4">
                            <p class="font-bold text-xs sm:text-sm text-gray-900">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $item->user->email }}</p>
                        </div>
                    </div>

                    {{-- Seller Rating --}}
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        @if($item->user->total_ratings > 0)
                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($item->user->average_rating))
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @elseif($i - 0.5 <= $item->user->average_rating)
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-yellow-400" viewBox="0 0 24 24">
                                                <defs>
                                                    <linearGradient id="half-{{ $i }}">
                                                        <stop offset="50%" stop-color="currentColor" stop-opacity="1"/>
                                                        <stop offset="50%" stop-color="#D1D5DB" stop-opacity="1"/>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-xs sm:text-sm font-semibold text-gray-700">{{ $item->user->average_rating }}</span>
                            </div>
                            <p class="text-xs text-gray-600">Based on {{ $item->user->total_ratings }} {{ Str::plural('review', $item->user->total_ratings) }}</p>
                        @else
                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 sm:w-5 h-4 sm:h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">No reviews yet</p>
                            <p class="text-xs text-gray-400 mt-1">Be the first to complete a deal and leave a review!</p>
                        @endif
                    </div>

                    {{-- WhatsApp Button --}}
                    <button onclick="handleWhatsAppClick()"
                       type="button"
                       class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 sm:py-4 px-4 sm:px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-center cursor-pointer text-sm sm:text-base">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 sm:w-6 h-5 sm:h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Contact Seller via WhatsApp
                        </div>
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-3">
                        Click to start a chat with pre-filled message
                    </p>

                    {{-- Seller Actions --}}
                    @auth
                        @if(auth()->id() === $item->user_id)
                            <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                                {{-- Edit and Delete Buttons --}}
                                @if(!$item->is_sold)
                                <div class="flex gap-2">
                                    <a href="{{ route('items.edit', $item->slug) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-2 sm:px-1 rounded-lg transition duration-150 ease-in-out shadow text-center text-sm cursor-pointer">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit Listing
                                        </div>
                                    </a>
                                    <button onclick="showDeletionRequestModal()" type="button" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-3 sm:px-4 rounded-lg transition duration-150 ease-in-out shadow text-center text-sm cursor-pointer">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Request Deletion
                                        </div>
                                    </button>
                                </div>
                                @endif
                                {{-- Premium Packages Status --}}
                                @if($activePremiumPackages->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($activePremiumPackages as $package)
                                            @if($package->package_type === 'hero')
                                                {{-- Hero Banner Status --}}
                                                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-300 rounded-lg p-4 text-center">
                                                    <div class="flex items-center justify-center text-blue-700 mb-1">
                                                        <span class="font-bold text-xs sm:text-sm">🎯 HERO BANNER</span>
                                                    </div>
                                                    <p class="text-xs text-blue-600">Active until {{ $package->expires_at->format('M d, Y') }}</p>
                                                </div>
                                            @elseif($package->package_type === 'featured')
                                                {{-- Featured Listing Status --}}
                                                <div class="bg-gradient-to-r from-purple-50 to-blue-50 border-2 border-purple-300 rounded-lg p-4 text-center">
                                                    <div class="flex items-center justify-center text-purple-700 mb-1">
                                                        <span class="font-bold text-xs sm:text-sm">⭐ FEATURED</span>
                                                    </div>
                                                    <p class="text-xs text-purple-600">Active until {{ $package->expires_at->format('M d, Y') }}</p>
                                                </div>
                                            @endif
                                        @endforeach

                                        {{-- Extend/Upgrade Link --}}
                                        <a href="{{ route('premium.packages', $item->slug) }}" class="block text-center text-xs sm:text-sm text-gray-700 hover:text-gray-900 font-semibold mt-2">
                                            Extend or Add More Packages →
                                        </a>
                                    </div>
                                @else
                                    {{-- No Premium - Show Boost Button --}}
                                    <a href="{{ route('premium.packages', $item->slug) }}" class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-3 px-4 sm:px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-center text-sm sm:text-base">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            Boost with Premium
                                        </div>
                                    </a>
                                @endif

                                {{-- Mark as Sold Button --}}
                                <form action="{{ route('transaction.markSold', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this item as sold? This will generate confirmation links for you and the buyer.');">
                                    @csrf
                                    <button type="submit" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 sm:px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-center text-sm sm:text-base">
                                        <div class="flex items-center justify-center cursor-pointer">
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Mark as Sold
                                        </div>
                                    </button>
                                </form>
                                <p class="text-xs text-gray-500 text-center">Generate transaction confirmation links</p>
                            </div>
                        @endif

                        @if($item->is_sold)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                    <svg class="w-6 sm:w-8 h-6 sm:h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-bold text-sm text-green-800">SOLD</p>
                                    <p class="text-xs text-green-600 mt-1">This item has been sold</p>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Safety Tips --}}
                {{-- <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 sm:p-6 mt-6">
                    <div class="flex items-start">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6 text-amber-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-amber-900 mb-2 text-xs sm:text-sm">Safety Tips</h4>
                            <ul class="text-xs text-amber-800 space-y-1">
                                <li>• Meet in public places</li>
                                <li>• Inspect items before buying</li>
                                <li>• Never share sensitive info</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Store WhatsApp link for later use
    const whatsappLink = '{{ $whatsappLink }}';
    const isUserLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    const loginUrl = '{{ route("login") }}';

    // Handle WhatsApp button click
    function handleWhatsAppClick() {
        // If user is not logged in, redirect to login
        if (!isUserLoggedIn) {
            window.location.href = loginUrl;
            return;
        }
        
        // Check if WhatsApp link contains verification_required parameter
        if (whatsappLink.includes('verification_required=true')) {
            window.location.href = whatsappLink;
            return;
        }
        
        // Otherwise show the disclaimer modal
        showDisclaimerModal();
    }

    // Show disclaimer modal
    function showDisclaimerModal() {
        const modal = document.getElementById('disclaimerModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    // Close disclaimer modal
    function closeDisclaimerModal() {
        const modal = document.getElementById('disclaimerModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling

        // Reset checkbox
        const checkbox = document.getElementById('disclaimerCheckbox');
        checkbox.checked = false;
        updateProceedButton();
    }

    // Update proceed button state based on checkbox
    function updateProceedButton() {
        const checkbox = document.getElementById('disclaimerCheckbox');
        const button = document.getElementById('proceedButton');

        if (checkbox.checked) {
            button.disabled = false;
            button.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'opacity-60');
            button.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'text-white', 'cursor-pointer');
        } else {
            button.disabled = true;
            button.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'text-white', 'cursor-pointer');
            button.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'opacity-60');
        }
    }

    // Proceed to WhatsApp when checkbox is checked
    function proceedToWhatsApp() {
        const checkbox = document.getElementById('disclaimerCheckbox');
        if (checkbox.checked) {
            window.open(whatsappLink, '_blank');
            closeDisclaimerModal();
        }
    }

    // Show deletion request modal
    function showDeletionRequestModal() {
        const modal = document.getElementById('deletionRequestModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    // Close deletion request modal
    function closeDeletionRequestModal() {
        const modal = document.getElementById('deletionRequestModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
        
        // Reset form
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }

    // Add event listener to checkbox
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('disclaimerCheckbox');
        checkbox.addEventListener('change', updateProceedButton);

        // Close disclaimer modal when clicking outside
        const disclaimerModal = document.getElementById('disclaimerModal');
        disclaimerModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDisclaimerModal();
            }
        });

        // Close deletion request modal when clicking outside
        const deletionModal = document.getElementById('deletionRequestModal');
        deletionModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeletionRequestModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close disclaimer modal if open
                const disclaimerModal = document.getElementById('disclaimerModal');
                if (disclaimerModal && !disclaimerModal.classList.contains('hidden')) {
                    closeDisclaimerModal();
                }
                
                // Close deletion request modal if open
                const deletionModal = document.getElementById('deletionRequestModal');
                if (deletionModal && !deletionModal.classList.contains('hidden')) {
                    closeDeletionRequestModal();
                }
            }
        });
    });
</script>
@endpush
@endsection