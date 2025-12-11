<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Policies\InvoicePolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\ConsultationPolicy;
use App\Policies\PrescriptionPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
    
    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
        Consultation::class => ConsultationPolicy::class,
        Prescription::class => PrescriptionPolicy::class,
        Invoice::class => InvoicePolicy::class,
    ];
}
