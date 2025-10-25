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
    ];

    protected $casts = [
        'working_hours' => 'array',
        'is_available' => 'boolean',
    ];

    // Relationships
    public function services()
    {
        return $this->belongsToMany(Service::class, 'specialist_services');
    }
    public function specialists()
    {
        return $this->belongsToMany(Specialist::class, 'service_specialist');
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
