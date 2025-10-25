<x-manager-layout>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3 sm:mb-0">Payments</h1>
    </div>

    <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="hidden md:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Service</th>
                    <th class="hidden lg:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Payment Method</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount Paid</th>
                    <th class="hidden lg:table-cell px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total Due</th>
                    <th class="px-4 sm:px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($payments as $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $payment->id }}</td>
                        <td class="px-4 sm:px-6 py-4 text-sm font-medium text-gray-900">{{ $payment->user->name ?? 'N/A' }}</td>

                        <td class="hidden md:table-cell px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $payment->service->name ?? 'N/A' }}</td>
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $payment->payment_method ?? '—' }}</td>

                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            @if ($payment->payment_status === 'paid')
                                <span class="bg-green-100 text-green-800 px-3 py-1 text-xs rounded-full">Paid</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 text-xs rounded-full">Pending</span>
                            @endif
                        </td>

                        <!-- Amount Paid (always visible) -->
                        <td class="px-4 sm:px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                            @if($payment->amount_paid)
                                ₱{{ number_format($payment->amount_paid, 2) }}
                            @else
                                <span class="text-gray-400 italic">Not paid yet</span>
                            @endif
                        </td>

                        <!-- Total Due (hidden on mobile) -->
                        <td class="hidden lg:table-cell px-4 sm:px-6 py-4 text-sm font-semibold text-gray-700">
                            ₱{{ number_format($payment->total_price, 2) }}
                        </td>

                        <td class="px-4 sm:px-6 py-4 text-sm text-right space-x-1 sm:space-x-2 whitespace-nowrap">
                            @if ($payment->payment_status === 'pending')
                                <button onclick="openPaymentModal({{ $payment->id }})"
                                    class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md transition">
                                    Record
                                </button>
                            @else
                                <button onclick="openEditModal({{ $payment->id }}, {{ $payment->amount_paid }})"
                                    class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition">
                                    Edit
                                </button>
                            @endif

                            <form method="POST" action="{{ route('manager.payments.delete', $payment->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this payment record?')"
                                    class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 sm:px-6 py-6 text-center text-gray-500 text-sm">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Record Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-auto p-6 animate-fadeIn">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Record Customer Payment</h2>
            <form id="paymentForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid (₱)</label>
                    <input type="number" step="0.01" name="amount_paid" id="amountPaid"
                        class="w-full border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 p-2"
                        placeholder="Enter payment amount" required>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                        onclick="closePaymentModal()"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-200 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 focus:ring-2 focus:ring-green-400 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Payment Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50 px-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-auto p-6 animate-fadeIn">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Payment</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Amount Paid (₱)</label>
                    <input type="number" step="0.01" name="amount_paid" id="editAmount"
                        class="w-full border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2"
                        required>
                </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button"
                            onclick="closeEditModal()"
                            class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
                            Update
                        </button>
                    </div>

            </form>
        </div>
    </div>

    <script>
        function openPaymentModal(id) {
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentForm').action = `/manager/payments/${id}/record`;
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function openEditModal(id, amount) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editAmount').value = amount;
            document.getElementById('editForm').action = `/manager/payments/${id}/update`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
    </style>
</x-manager-layout>
