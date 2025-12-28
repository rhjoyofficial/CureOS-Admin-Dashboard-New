<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'email_verified_at',
        'nid',
        'father_name',
        'mother_name',
        'district',
        'upazila',
        'village',
        'post_office',
        'post_code',
        'marital_status',
        'religion',
        'date_of_birth',
        'blood_group',
        'emergency_contact',
        'bmdc_registration',
        'specialization',
        'consultation_fee',
        'qualifications',
        'experience'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'consultation_fee' => 'decimal:2',
    ];

    // Relationships
    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function createdPatients()
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDoctors($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'Doctor');
        });
    }

    // Helpers
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function isDoctor()
    {
        return $this->hasRole('Doctor');
    }

    public function isStaff()
    {
        return $this->hasRole('Staff');
    }

    public function isPatient()
    {
        return $this->hasRole('Patient');
    }
    /**
     * Scope a query to search users by name, email, or phone.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }
}
