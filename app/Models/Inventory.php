<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'name',
        'description',
        'category',
        'quantity',
        'min_quantity',
        'unit_price',
        'supplier',
        'expiry_date',
        'image',
        'is_active',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_quantity');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper methods
    public function isLowStock()
    {
        return $this->quantity <= $this->min_quantity;
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }
}
