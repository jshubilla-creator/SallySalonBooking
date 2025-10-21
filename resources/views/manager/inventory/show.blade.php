<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $inventory->name }}</h1>
                <p class="mt-2 text-lg text-gray-600">Inventory item details</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('manager.inventory.edit', $inventory) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                    Edit Item
                </a>
                <a href="{{ route('manager.inventory.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Item Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Item Information</h3>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inventory->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $inventory->category }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Current Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $inventory->quantity }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Minimum Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inventory->min_quantity }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Unit Price</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($inventory->unit_price)
                                    ${{ number_format($inventory->unit_price, 2) }}
                                @else
                                    Not set
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Supplier</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inventory->supplier ?? 'Not specified' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Expiry Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($inventory->expiry_date)
                                    {{ $inventory->expiry_date->format('M d, Y') }}
                                    @if($inventory->isExpired())
                                        <span class="ml-2 text-red-600 font-medium">(Expired)</span>
                                    @endif
                                @else
                                    No expiry date
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($inventory->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    @if($inventory->description)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $inventory->description }}</dd>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="space-y-6">
            <!-- Stock Status -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Stock Status</h3>

                    @if($inventory->quantity <= $inventory->min_quantity)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Low Stock Alert</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>This item is running low on stock. Consider reordering soon.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($inventory->isExpired())
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-orange-800">Expired Item</h3>
                                    <div class="mt-2 text-sm text-orange-700">
                                        <p>This item has expired and should be removed from inventory.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">In Stock</h3>
                                    <div class="mt-2 text-sm text-green-700">
                                        <p>This item is well stocked and available for use.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('manager.inventory.edit', $inventory) }}"
                           class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                            Edit Item
                        </a>

                        <button onclick="adjustQuantity()"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Adjust Quantity
                        </button>

                        <form method="POST" action="{{ route('manager.inventory.destroy', $inventory) }}" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this item? This action cannot be undone.')"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors duration-200">
                                Delete Item
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Item History -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Item History</h3>

                    <div class="text-sm text-gray-500">
                        <p>Created: {{ $inventory->created_at->format('M d, Y H:i') }}</p>
                        <p>Last updated: {{ $inventory->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantity Adjustment Modal -->
    <div id="quantityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Adjust Quantity</h3>
                </div>
                <form id="quantityForm" method="POST" action="{{ route('manager.inventory.update', $inventory) }}">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-4">
                        <div>
                            <label for="new_quantity" class="block text-sm font-medium text-gray-700 mb-2">New Quantity</label>
                            <input type="number"
                                   name="quantity"
                                   id="new_quantity"
                                   value="{{ $inventory->quantity }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   required>
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-2">
                        <button type="button"
                                onclick="closeQuantityModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                            Update Quantity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function adjustQuantity() {
            document.getElementById('quantityModal').classList.remove('hidden');
        }

        function closeQuantityModal() {
            document.getElementById('quantityModal').classList.add('hidden');
        }
    </script>
</x-manager-layout>
