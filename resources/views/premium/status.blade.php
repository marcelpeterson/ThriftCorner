@extends('layouts.app')

@section('title', 'Payment Status - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto max-md:mt-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 max-md:font-black">Payment Status</h1>
            <p class="text-gray-600">Order #{{ $payment->order_id }}</p>
        </div>

        {{-- Status Alert --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Payment Status Display --}}
        <div class="mb-8">
            <div class="flex items-center justify-center mb-4">
                @if($payment->status === 'pending')
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                @elseif($payment->status === 'success')
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                @else
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                @endif
            </div>
            
            <div class="text-center">
                <h2 class="text-2xl font-bold mb-2 
                    @if($payment->status === 'pending') text-yellow-600
                    @elseif($payment->status === 'success') text-green-600
                    @else text-red-600
                    @endif">
                    @if($payment->status === 'pending')
                        Payment Pending
                    @elseif($payment->status === 'success')
                        Payment Confirmed
                    @else
                        Payment Failed
                    @endif
                </h2>
                <p class="text-gray-600">
                    @if($payment->status === 'pending')
                        @if($payment->proof_of_payment)
                            Your payment proof has been uploaded. Waiting for admin confirmation.
                        @else
                            Please upload your payment proof below.
                        @endif
                    @elseif($payment->status === 'success')
                        Your payment has been confirmed. Your premium listing is now active!
                    @else
                        There was an issue with your payment. Please try again or contact support.
                    @endif
                </p>
            </div>
        </div>

        {{-- Payment Details --}}
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4">Payment Details</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Item:</span>
                    <span class="font-semibold text-gray-900">
                        @if($payment->item)
                            {{ $payment->item->name }}
                        @else
                            <span class="text-gray-500 italic">Item deleted</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Package:</span>
                    <span class="font-semibold text-gray-900">
                        @if($payment->premiumListing)
                            {{ ucfirst($payment->premiumListing->package_type) }}
                        @else
                            <span class="text-gray-500 italic">Not available</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount:</span>
                    <span class="font-bold text-emerald-600">{{ rupiah($payment->amount) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Created:</span>
                    <span class="text-gray-900">{{ $payment->created_at->format('d M Y, H:i') }}</span>
                </div>
                @if($payment->confirmed_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Confirmed:</span>
                        <span class="text-gray-900">{{ $payment->confirmed_at->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Proof of Payment Upload --}}
        @if($payment->status === 'pending')
            @if(!$payment->proof_of_payment)
                <div class="bg-gradient-to-br from-emerald-50 to-blue-50 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Proof of Payment
                    </h3>
                    
                    <form action="{{ route('payment.uploadProof', $payment->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        
                        <div class="mb-4">
                            <div id="dropZone" class="relative border-2 border-dashed border-emerald-300 rounded-xl p-8 text-center hover:border-emerald-500 transition-all duration-200 bg-white/70 backdrop-blur cursor-pointer">
                                <input type="file" 
                                       name="proof_of_payment" 
                                       id="proof_of_payment" 
                                       accept="image/*"
                                       required
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                
                                <div id="uploadPlaceholder">
                                    <div class="mb-4">
                                        <div class="mx-auto w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <p class="text-lg font-semibold text-gray-700 mb-2">
                                        Drop your payment receipt here
                                    </p>
                                    <p class="text-sm text-gray-500 mb-4">
                                        or click to browse from your device
                                    </p>
                                    
                                    <div class="flex flex-wrap gap-2 justify-center text-xs text-gray-500">
                                        <span class="px-2 py-1 bg-gray-100 rounded">PNG</span>
                                        <span class="px-2 py-1 bg-gray-100 rounded">JPG</span>
                                        <span class="px-2 py-1 bg-gray-100 rounded">JPEG</span>
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded">Max 5MB</span>
                                    </div>
                                </div>
                                
                                <div id="uploadPreview" class="hidden">
                                    <img id="previewImage" class="mx-auto max-h-40 rounded-lg mb-3" alt="Preview">
                                    <p id="fileName" class="text-sm font-medium text-gray-700 mb-1"></p>
                                    <p id="fileSize" class="text-xs text-gray-500"></p>
                                    <button type="button" id="changeFile" class="mt-3 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                        Change file
                                    </button>
                                </div>
                            </div>
                            
                            @error('proof_of_payment')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit" id="submitBtn" disabled class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span id="submitText">Upload Proof of Payment</span>
                            </div>
                        </button>
                    </form>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropZone = document.getElementById('dropZone');
                        const fileInput = document.getElementById('proof_of_payment');
                        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
                        const uploadPreview = document.getElementById('uploadPreview');
                        const previewImage = document.getElementById('previewImage');
                        const fileName = document.getElementById('fileName');
                        const fileSize = document.getElementById('fileSize');
                        const submitBtn = document.getElementById('submitBtn');
                        const changeFileBtn = document.getElementById('changeFile');
                        const form = document.getElementById('uploadForm');
                        const submitText = document.getElementById('submitText');
                        
                        // Drag and drop handlers
                        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                            dropZone.addEventListener(eventName, preventDefaults, false);
                        });
                        
                        function preventDefaults(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                        
                        ['dragenter', 'dragover'].forEach(eventName => {
                            dropZone.addEventListener(eventName, highlight, false);
                        });
                        
                        ['dragleave', 'drop'].forEach(eventName => {
                            dropZone.addEventListener(eventName, unhighlight, false);
                        });
                        
                        function highlight(e) {
                            dropZone.classList.add('border-emerald-500', 'bg-emerald-50/50');
                        }
                        
                        function unhighlight(e) {
                            dropZone.classList.remove('border-emerald-500', 'bg-emerald-50/50');
                        }
                        
                        // Handle dropped files
                        dropZone.addEventListener('drop', handleDrop, false);
                        
                        function handleDrop(e) {
                            const dt = e.dataTransfer;
                            const files = dt.files;
                            
                            if (files.length > 0) {
                                fileInput.files = files;
                                handleFile(files[0]);
                            }
                        }
                        
                        // Handle file selection
                        fileInput.addEventListener('change', function(e) {
                            if (this.files && this.files[0]) {
                                handleFile(this.files[0]);
                            }
                        });
                        
                        // Handle file preview
                        function handleFile(file) {
                            // Validate file type
                            if (!file.type.startsWith('image/')) {
                                alert('Please select an image file');
                                return;
                            }
                            
                            // Validate file size (5MB)
                            if (file.size > 5 * 1024 * 1024) {
                                alert('File size must be less than 5MB');
                                fileInput.value = '';
                                return;
                            }
                            
                            // Show preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImage.src = e.target.result;
                                fileName.textContent = file.name;
                                fileSize.textContent = formatFileSize(file.size);
                                
                                uploadPlaceholder.classList.add('hidden');
                                uploadPreview.classList.remove('hidden');
                                submitBtn.disabled = false;
                            };
                            reader.readAsDataURL(file);
                        }
                        
                        // Format file size
                        function formatFileSize(bytes) {
                            if (bytes === 0) return '0 Bytes';
                            const k = 1024;
                            const sizes = ['Bytes', 'KB', 'MB'];
                            const i = Math.floor(Math.log(bytes) / Math.log(k));
                            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                        }
                        
                        // Change file button
                        changeFileBtn?.addEventListener('click', function() {
                            fileInput.value = '';
                            uploadPlaceholder.classList.remove('hidden');
                            uploadPreview.classList.add('hidden');
                            submitBtn.disabled = true;
                        });
                        
                        // Form submission
                        form.addEventListener('submit', function() {
                            submitBtn.disabled = true;
                            submitText.textContent = 'Uploading...';
                        });
                    });
                </script>
            @else
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Proof of Payment Uploaded</h3>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Payment proof uploaded successfully</p>
                                <p class="text-sm text-gray-600">Waiting for admin verification (usually within 24 hours)</p>
                            </div>
                        </div>
                        @if(Storage::exists('public/' . $payment->proof_of_payment))
                            <a href="{{ Storage::url($payment->proof_of_payment) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                View Proof
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @endif

        {{-- Bank Transfer Reminder --}}
        @if($payment->status === 'pending' && !$payment->proof_of_payment)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Please transfer <strong>{{ rupiah($payment->amount) }}</strong> to:
                </p>
                <div class="mt-2 pl-5">
                    <p class="text-sm text-blue-900 font-semibold">
                        {{ $payment->bank_name }} - {{ $payment->account_number }}<br>
                        A/N {{ $payment->account_name }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="flex gap-3">
            @if($payment->status === 'success' && $payment->item)
                <a href="{{ route('items.view', $payment->item->slug) }}" class="flex-1 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors text-center">
                    View Your Premium Listing
                </a>
            @elseif($payment->status !== 'success')
                <a href="{{ route('payment.checkout', $payment->id) }}" class="flex-1 py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-lg transition-colors text-center max-md:hidden">
                    Back to Payment Instructions
                </a>
                <a href="{{ route('payment.checkout', $payment->id) }}" class="flex-1 py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-lg transition-colors text-center max-md:block md:hidden">
                    Back
                </a>
            @endif
            
            @if($payment->item)
                <a href="{{ route('items.view', $payment->item->slug) }}" class="flex-1 py-3 px-4 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-lg transition-colors text-center">
                    View Item
                </a>
            @else
                <a href="{{ route('home') }}" class="flex-1 py-3 px-4 border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-lg transition-colors text-center">
                    Back to Home
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
