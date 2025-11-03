@extends('layouts.app')

@section('title', 'Manage Transactions - ' . config('app.name'))

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Manage Transactions</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">View all platform transactions</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="max-md:hidden px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors text-sm">
            ← Back to Dashboard
        </a>
    </div>

    {{-- Transactions Table/Cards --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Desktop Table View --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seller</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $transaction->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($transaction->item->images->count() > 0)
                                        <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}" alt="{{ $transaction->item->name }}" class="w-10 h-10 rounded object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($transaction->item->name, 30) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $transaction->seller->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->seller->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->buyer)
                                    <div class="text-sm text-gray-900">{{ $transaction->buyer->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $transaction->buyer->email }}</div>
                                @else
                                    <span class="text-sm text-gray-400 italic">Not assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-emerald-600">{{ $transaction->item->price_rupiah }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->status === 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @elseif($transaction->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($transaction->status === 'cancelled')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                                
                                @if($transaction->status === 'pending')
                                    <div class="mt-1 text-xs text-gray-500">
                                        @if($transaction->seller_confirmed)
                                            <span class="text-green-600">✓ Seller</span>
                                        @else
                                            <span class="text-gray-400">○ Seller</span>
                                        @endif
                                        @if($transaction->buyer_confirmed)
                                            <span class="text-green-600">✓ Buyer</span>
                                        @else
                                            <span class="text-gray-400">○ Buyer</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($transaction->completed_at)
                                    {{ $transaction->completed_at->format('M d, Y') }}
                                @else
                                    {{ $transaction->created_at->format('M d, Y') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($transaction->status === 'completed')
                                    <a href="{{ route('transaction.report', $transaction->id) }}" class="text-blue-600 hover:text-blue-900">
                                        View Report
                                    </a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden divide-y divide-gray-200">
            @foreach($transactions as $transaction)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500 font-medium mb-1">Transaction #{{ $transaction->id }}</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ Str::limit($transaction->item->name, 30) }}</p>
                        </div>
                        @if($transaction->status === 'completed')
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">
                                Completed
                            </span>
                        @elseif($transaction->status === 'pending')
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">
                                Pending
                            </span>
                        @elseif($transaction->status === 'cancelled')
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 flex-shrink-0">
                                Cancelled
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 flex-shrink-0">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        @endif
                    </div>
                    <div class="space-y-2 text-sm mb-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Price:</span>
                            <span class="font-medium text-emerald-600">{{ $transaction->item->price_rupiah }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Seller:</span>
                            <span class="text-gray-700 truncate">{{ $transaction->seller->full_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Buyer:</span>
                            <span class="text-gray-700 truncate">{{ $transaction->buyer ? $transaction->buyer->full_name : 'Not assigned' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="text-gray-700">{{ ($transaction->completed_at ?? $transaction->created_at)->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @if($transaction->status === 'completed')
                        <a href="{{ route('transaction.report', $transaction->id) }}" class="block w-full px-3 py-2 text-center text-xs font-medium rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-colors">
                            View Report
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-50 px-6 py-3">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
