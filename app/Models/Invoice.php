<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'payment_status',
        'total_amount',
        'pdf_path',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function patient()
    {
        return $this->throughConsultation()->throughAppointment()->hasPatient();
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Methods
    public function markAsPaid()
    {
        $this->update(['payment_status' => 'paid']);
    }

    public function markAsPartial($amount)
    {
        $this->update([
            'payment_status' => 'partial',
            'total_amount' => $this->total_amount - $amount,
        ]);
    }

    public function addItem($description, $fee)
    {
        return $this->items()->create([
            'service_description' => $description,
            'fee' => $fee,
        ]);
    }

    public function calculateTotal()
    {
        return $this->items()->sum('fee');
    }

    public function updateTotal()
    {
        $this->update(['total_amount' => $this->calculateTotal()]);
    }

    public function hasPdf()
    {
        return !is_null($this->pdf_path) && file_exists(storage_path('app/' . $this->pdf_path));
    }
}