<x-admin-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Staff Member Details</h1>
                        <p class="mt-2 text-lg text-gray-600">View staff member information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.staff.edit', $staff) }}"
                           class="px-4 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Edit Staff Member
                        </a>
                        <a href="{{ route('admin.staff.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Back to Staff
                        </a>
                    </div>
                </div>
            </div>

            <!-- Staff Information -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Personal Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg text-gray-900">{{ $staff->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-lg text-gray-900">{{ $staff->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg text-gray-900">{{ $staff->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $staff->hasRole('admin') ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $staff->roles->first()->name ?? 'No Role' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                            <p class="text-lg text-gray-900">{{ $staff->date_of_birth ? $staff->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                            <p class="text-lg text-gray-900">{{ ucfirst($staff->gender ?? 'Not specified') }}</p>
                        </div>
                    </div>

                    @if($staff->address)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                            <p class="text-lg text-gray-900">{{ $staff->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Information -->
            <div class="mt-6 bg-white rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Account Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                            <p class="text-lg text-gray-900">{{ $staff->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-lg text-gray-900">{{ $staff->updated_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Verified</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $staff->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $staff->email_verified_at ? 'Verified' : 'Not Verified' }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Account Status</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 bg-white rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Actions</h2>
                </div>
                <div class="p-6">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.staff.edit', $staff) }}"
                           class="px-4 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Edit Staff Member
                        </a>
                        <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}"
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this staff member? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Delete Staff Member
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
