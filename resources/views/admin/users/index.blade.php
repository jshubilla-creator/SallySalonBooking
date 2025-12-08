<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Staff Management</h2>
                        <a href="{{ route('admin.users.create') }}" 
                           class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-600 hover:to-purple-700">
                            Add Staff Member
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->roles->first()->name ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <button onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')" 
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal 
        id="deleteModal"
        title="Delete Staff Member"
        message="Are you sure you want to delete this staff member? This action cannot be undone."
        confirmText="Delete"
        cancelText="Cancel"
    />

    <script>
        function confirmDelete(userId, userName) {
            const modal = document.getElementById('deleteModal');
            const form = modal.querySelector('form');
            const message = modal.querySelector('[data-message]');
            
            message.textContent = `Are you sure you want to delete ${userName}? This action cannot be undone.`;
            form.action = `/admin/users/${userId}`;
            
            const methodInput = form.querySelector('input[name="_method"]') || document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            if (!form.querySelector('input[name="_method"]')) {
                form.appendChild(methodInput);
            }
            
            modal.classList.remove('hidden');
        }
    </script>
</x-admin-layout>