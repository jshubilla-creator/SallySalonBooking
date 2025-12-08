<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'profile_picture',
        'terms_accepted',
        'terms_accepted_at',
        'is_banned',
        'banned_at',
        'ban_reason',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'terms_accepted_at' => 'datetime',
            'date_of_birth' => 'date',
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    // Helper methods
    public function isCustomer()
    {
        return $this->hasRole('customer');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture ? asset('storage/' . $this->profile_picture) : null;
    }

    // Ban/Unban methods
    public function ban($reason = null)
    {
        $this->update([
            'is_banned' => true,
            'banned_at' => now(),
            'ban_reason' => $reason,
        ]);
    }

    public function unban()
    {
        $this->update([
            'is_banned' => false,
            'banned_at' => null,
            'ban_reason' => null,
        ]);
    }

    public function isBanned()
    {
        return $this->is_banned;
    }

    // 2FA methods
    public function generateTwoFactorCode()
    {
        $this->update([
            'two_factor_code' => rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(5),
        ]);
        
        // Send email instead of SMS
        $this->sendTwoFactorEmail();
    }
    
    public function sendTwoFactorEmail()
    {
        \Mail::send('emails.two-factor-code', [
            'user' => $this,
            'code' => $this->two_factor_code
        ], function ($message) {
            $message->to($this->email)
                    ->subject('🔐 Sally Salon - Your Verification Code');
        });
    }

    public function resetTwoFactorCode()
    {
        $this->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }

    public function isTwoFactorCodeValid($code)
    {
        return $this->two_factor_code === $code && 
               $this->two_factor_expires_at && 
               $this->two_factor_expires_at->isFuture();
    }
}
