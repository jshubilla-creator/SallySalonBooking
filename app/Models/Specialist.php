<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bio',
        'specialization',
        'experience_years',
        'profile_image',
        'working_hours',
        'is_available',
        'current_lat',
        'current_lng',
        'location_updated_at',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'is_available' => 'boolean',
        'current_lat' => 'float',
        'current_lng' => 'float',
        'location_updated_at' => 'datetime',
    ];

    // Relationships
    public function services()
    {
        return $this->belongsToMany(Service::class, 'specialist_services');
    }
    

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeBySpecialization($query, $specialization)
    {
        return $query->where('specialization', $specialization);
    }


}
