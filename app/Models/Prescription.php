<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'notes',
        'pdf_path',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function appointment()
    {
        return $this->throughConsultation()->hasAppointment();
    }

    public function patient()
    {
        return $this->throughConsultation()->throughAppointment()->hasPatient();
    }

    // Methods
    public function totalMedicines()
    {
        return $this->items()->count();
    }

    public function hasPdf()
    {
        return !is_null($this->pdf_path) && file_exists(storage_path('app/' . $this->pdf_path));
    }
}