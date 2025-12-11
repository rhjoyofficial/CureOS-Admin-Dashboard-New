<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'visit_notes',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function patient()
    {
        return $this->throughAppointment()->hasPatient();
    }

    public function doctor()
    {
        return $this->throughAppointment()->hasDoctor();
    }
}