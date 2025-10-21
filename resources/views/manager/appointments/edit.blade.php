<x-manager-layout>
    <h1 class="text-2xl font-bold mb-4">Edit Appointment #{{ $appointment->id }}</h1>

    <form method="POST" action="{{ route('manager.appointments.update', $appointment) }}" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Service</label>
            <select name="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Specialist</label>
            <select name="specialist_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($specialists as $specialist)
                    <option value="{{ $specialist->id }}" {{ $appointment->specialist_id == $specialist->id ? 'selected' : '' }}>
                        {{ $specialist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $appointment->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('manager.appointments.show', $appointment) }}" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Save Changes</button>
        </div>
    </form>
</x-manager-layout>
