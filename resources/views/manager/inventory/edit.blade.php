<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Inventory Item</h1>
                <p class="mt-2 text-lg text-gray-600">Update {{ $inventory->name }}</p>
            </div>
            <a href="{{ route('manager.inventory.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Inventory
            </a>
        </div>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('manager.inventory.update', $inventory) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Item Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $inventory->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('description') border-red-500 @enderror">{{ old('description', $inventory->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category"
                                id="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">Select Category</option>
                            <option value="Product" {{ old('category', $inventory->category) === 'Product' ? 'selected' : '' }}>Product</option>
                            <option value="Supply" {{ old('category', $inventory->category) === 'Supply' ? 'selected' : '' }}>Supply</option>
                            <option value="Equipment" {{ old('category', $inventory->category) === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                            <option value="Tool" {{ old('category', $inventory->category) === 'Tool' ? 'selected' : '' }}>Tool</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                        <input type="text"
                               name="supplier"
                               id="supplier"
                               value="{{ old('supplier', $inventory->supplier) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('supplier') border-red-500 @enderror">
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Current Quantity *</label>
                        <input type="number"
                               name="quantity"
                               id="quantity"
                               value="{{ old('quantity', $inventory->quantity) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('quantity') border-red-500 @enderror"
                               required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Min Quantity -->
                    <div>
                        <label for="min_quantity" class="block text-sm font-medium text-gray-700 mb-2">Minimum Quantity *</label>
                        <input type="number"
                               name="min_quantity"
                               id="min_quantity"
                               value="{{ old('min_quantity', $inventory->min_quantity) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('min_quantity') border-red-500 @enderror"
                               required>
                        @error('min_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit Price -->
                    <div>
                        <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number"
                                   name="unit_price"
                                   id="unit_price"
                                   value="{{ old('unit_price', $inventory->unit_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('unit_price') border-red-500 @enderror">
                        </div>
                        @error('unit_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                        <input type="date"
                               name="expiry_date"
                               id="expiry_date"
                               value="{{ old('expiry_date', $inventory->expiry_date?->format('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('expiry_date') border-red-500 @enderror">
                        @error('expiry_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', $inventory->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Active (item is available for use)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('manager.inventory.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Update Item
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-manager-layout>
