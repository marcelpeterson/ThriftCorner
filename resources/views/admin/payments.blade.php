@extends('layouts.app')

@section('title', 'Payment Management - Admin')

@section('content')
<div class="space-y-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Payment Management</h1>
        <p class="text-gray-600 mt-2">Manage and confirm manual bank transfer payments</p>
    </div>

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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proof</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $payment->order_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $payment->user->first_name }} {{ $payment->user->last_name }}<br>
                                <span class="text-xs text-gray-400">{{ $payment->user->email }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($payment->item)
                                    <a href="{{ route('items.view', $payment->item->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        {{ Str::limit($payment->item->name, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">Item deleted</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($payment->premiumListing)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($payment->premiumListing->package_type === 'hero') bg-purple-100 text-purple-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($payment->premiumListing->package_type) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                {{ rupiah($payment->amount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif($payment->status === 'success')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Confirmed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($payment->proof_of_payment)
                                    <a href="{{ Storage::url($payment->proof_of_payment) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $payment->created_at->format('d M Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $payment->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($payment->status === 'pending')
                                    <div class="flex space-x-2">
                                        <button onclick="confirmPayment('{{ $payment->id }}')" 
                                                class="text-green-600 hover:text-green-900 cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                        <button onclick="rejectPayment('{{ $payment->id }}')" 
                                                class="text-red-600 hover:text-red-900 cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    @if($payment->admin_notes)
                                        <button onclick="viewNotes('{{ addslashes($payment->admin_notes) }}')" 
                                                class="text-gray-600 hover:text-gray-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                No payments found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Confirm Payment Modal --}}
<div id="confirmModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-4">
        <div class="fixed inset-0 transition-opacity z-40" style="background-color: rgba(0, 0, 0, 0.5);" onclick="closeModal('confirmModal')"></div>
        <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-50">
            <form id="confirmForm" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirm Payment</h3>
                    <div>
                        <label for="confirm_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                        <textarea id="confirm_notes" name="admin_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="submitConfirmForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Confirm Payment
                    </button>
                    <button type="button" onclick="closeModal('confirmModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Payment Modal --}}
<div id="rejectModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-4">
        <div class="fixed inset-0 transition-opacity z-40" style="background-color: rgba(0, 0, 0, 0.5);" onclick="closeModal('rejectModal')"></div>
        <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-50">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Reject Payment</h3>
                    <div>
                        <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection (Required)</label>
                        <textarea id="reject_notes" name="admin_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm p-2" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="submitRejectForm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Reject Payment
                    </button>
                    <button type="button" onclick="closeModal('rejectModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- View Notes Modal --}}
<div id="notesModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 py-4">
        <div class="fixed inset-0 transition-opacity z-40" style="background-color: rgba(0, 0, 0, 0.5);" onclick="closeModal('notesModal')"></div>
        <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full z-50">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Admin Notes</h3>
                <p id="notesContent" class="text-gray-700"></p>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <button type="button" onclick="closeModal('notesModal')" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmPayment(paymentId) {
    const form = document.getElementById('confirmForm');
    form.action = '/admin/payments/' + paymentId + '/confirm';
    document.getElementById('confirmModal').classList.remove('hidden');
    console.log('Confirm modal opened for payment:', paymentId);
}

function rejectPayment(paymentId) {
    const form = document.getElementById('rejectForm');
    form.action = '/admin/payments/' + paymentId + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
    console.log('Reject modal opened for payment:', paymentId);
}

function submitConfirmForm() {
    console.log('Submit button clicked!');
    const form = document.getElementById('confirmForm');
    if (form && form.action) {
        console.log('Submitting form to:', form.action);
        form.submit();
    } else {
        console.error('Form not found or action not set!');
    }
}

function submitRejectForm() {
    console.log('Reject submit button clicked!');
    const form = document.getElementById('rejectForm');
    const notesField = document.getElementById('reject_notes');
    
    // Validate required field
    if (!notesField.value.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    if (form && form.action) {
        console.log('Submitting reject form to:', form.action);
        form.submit();
    } else {
        console.error('Form not found or action not set!');
    }
}

function viewNotes(notes) {
    document.getElementById('notesContent').textContent = notes;
    document.getElementById('notesModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>
@endsection
