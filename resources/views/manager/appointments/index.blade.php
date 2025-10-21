<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Appointments</h1>
                <p class="mt-2 text-lg text-gray-600">Manage all salon appointments</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('manager.appointments.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                    New Appointment
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('manager.appointments.index') }}" class="space-y-4">
            <!-- Search Bar -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by customer name, email, service, or specialist..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date"
                           name="date"
                           id="date"
                           value="{{ request('date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label for="specialist_id" class="block text-sm font-medium text-gray-700 mb-1">Specialist</label>
                    <select name="specialist_id" id="specialist_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Specialists</option>
                        @foreach($specialists as $specialist)
                            <option value="{{ $specialist->id }}" {{ request('specialist_id') == $specialist->id ? 'selected' : '' }}>
                                {{ $specialist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                        Filter
                    </button>
                    <a href="{{ route('manager.appointments.index') }}"
                       class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialist</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-xs sm:text-sm font-medium text-green-600">{{ substr($appointment->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-2 sm:ml-4">
                                            <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $appointment->user->name }}</div>
                                            <div class="text-xs sm:text-sm text-gray-500">{{ $appointment->user->email }}</div>
                                            <!-- Show service and specialist on mobile -->
                                            <div class="sm:hidden text-xs text-gray-500 mt-1">
                                                {{ $appointment->service->name }} • {{ $appointment->specialist->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->service->category }}</div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->specialist->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->specialist->specialization }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ \App\Helpers\TimeHelper::formatTimeRange($appointment->start_time, $appointment->end_time) }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($appointment->status === 'completed') bg-gray-100 text-gray-800
                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($appointment->total_price, 2) }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('manager.appointments.show', $appointment) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 hover:text-green-700 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>

                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('manager.appointments.approve', $appointment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($appointment->status, ['pending', 'confirmed']))
                                        <button type="button"
                                            onclick="openCancelModal('{{ route('manager.appointments.cancel', $appointment) }}')"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                                            Cancel
                                        </button>

                                            <form id="cancel-form-{{ $appointment->id }}" method="POST" action="{{ route('manager.appointments.cancel', $appointment) }}" class="hidden">
                                                @csrf
                                            </form>
                                        @endif

                                        @if($appointment->status === 'confirmed')
                                            <form method="POST" action="{{ route('manager.appointments.complete', $appointment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($appointments->hasPages())
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
<!-- Global Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h3 class="text-lg font-bold text-gray-900 mb-2">Cancel Appointment</h3>
      <p class="text-sm text-gray-600 mb-4">Please provide a reason for cancellation.</p>

      <form id="cancelForm" method="POST" action="" onsubmit="handleCancelSubmit(event)">
          @csrf
          <textarea name="cancel_reason" rows="3" required
              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
              placeholder="Type your cancellation reason here..."></textarea>

          <div class="flex justify-end space-x-2 mt-4">
              <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                  Cancel
              </button>
              <button id="cancelSubmitBtn" type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                  Confirm Cancel
              </button>
          </div>
      </form>
  </div>
</div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal />
    <script>
    let currentCancelAction = '';

    function openCancelModal(actionUrl) {
        currentCancelAction = actionUrl;
        document.getElementById('cancelForm').action = actionUrl;
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }

    async function handleCancelSubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('cancelSubmitBtn');
        btn.disabled = true;
        btn.textContent = 'Cancelling...';
        e.target.submit();
    }
</script>

</x-manager-layout>
