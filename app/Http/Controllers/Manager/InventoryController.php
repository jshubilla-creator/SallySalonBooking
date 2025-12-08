<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('low_stock') && $request->low_stock) {
    $query->whereRaw('quantity <= min_quantity');
        
        }
 

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock) {
            $query->whereRaw('quantity <= min_quantity');
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
            
        }

        $inventory = $query->orderBy('name')->paginate(10);
        $categories = Inventory::distinct()->pluck('category')->filter();

        // Check if there are any low stock items
        $lowStockItems = Inventory::whereColumn('quantity', '<=', 'min_quantity')->get();
        $lowStockCount = $lowStockItems->count();

        return view('manager.inventory.index', compact('inventory', 'categories', 'lowStockCount'));
    }

    public function create()
    {
        return view('manager.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        // Default to false if not provided
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Inventory::create($data);

        return redirect()->route('manager.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function show(Inventory $inventory)
    {
        return view('manager.inventory.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('manager.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'unit_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
    $data['is_active'] = $request->has('is_active');

        $inventory->update($data);

        return redirect()->route('manager.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('manager.inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }

    public function adjustQuantity(Request $request, Inventory $inventory)
    {
        $request->validate([
            'adjustment' => 'required|integer',
        ]);

        $newQuantity = $inventory->quantity + $request->adjustment;

        // Prevent negative quantity
        if ($newQuantity < 0) {
            return back()->with('error', 'Cannot adjust quantity below zero.');
        }

        $inventory->update(['quantity' => $newQuantity]);

        $actionWord = $request->adjustment > 0 ? 'increased' : 'decreased';
        $amount = abs($request->adjustment);

        return back()->with('success', "Inventory quantity {$actionWord} by {$amount}.");
    }
}
