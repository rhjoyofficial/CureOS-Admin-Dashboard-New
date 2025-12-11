<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'father_name',
        'mother_name',
        'husband_wife_name',
        'occupation',
        'division',
        'district',
        'upazila',
        'union',
        'village',
        'post_office',
        'post_code',
        'full_address',
        'blood_group',
        'marital_status',
        'religion',
        'nationality',
        'nid',
        'birth_certificate_no',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'allergies',
        'current_medications',
        'past_medical_history',
        'family_medical_history',
        'habits',
        'created_by',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasManyThrough(Consultation::class, Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasManyThrough(Prescription::class, Appointment::class);
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Appointment::class);
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('patient_id', 'like', "%{$search}%");
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? now()->diffInYears($this->date_of_birth) : null;
    }

    // Mutator for patient_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if (empty($patient->patient_id)) {
                $patient->patient_id = 'P-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
