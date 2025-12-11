<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PrescriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// Authenticated routes (all roles)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Users Management
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // All Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // All Appointments
    Route::resource('appointments', AppointmentController::class)->except(['show']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'markAsCompleted'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // All Consultations
    Route::resource('consultations', ConsultationController::class);

    // All Prescriptions
    Route::resource('prescriptions', PrescriptionController::class);
    Route::get('/prescriptions/{prescription}/download', [PrescriptionController::class, 'download'])->name('prescriptions.download');

    // All Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/appointments', [ReportController::class, 'appointments'])->name('appointments');
        Route::get('/billing', [ReportController::class, 'billing'])->name('billing');
        Route::get('/patients', [ReportController::class, 'patients'])->name('patients');
        Route::get('/doctors', [ReportController::class, 'doctors'])->name('doctors');
        Route::post('/export', [ReportController::class, 'export'])->name('export');
    });

    // System Settings
    Route::get('/system-settings', [SettingController::class, 'system'])->name('system-settings');
    Route::post('/system-settings', [SettingController::class, 'updateSystem'])->name('system-settings.update');
});

// Doctor routes
Route::middleware(['auth', 'verified', 'role:Doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    // Doctor Dashboard
    Route::get('/dashboard', [DashboardController::class, 'doctor'])->name('dashboard');

    // My Patients
    Route::get('/patients', [PatientController::class, 'doctorIndex'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'doctorShow'])->name('patients.show');

    // My Appointments
    Route::get('/appointments', [AppointmentController::class, 'doctorIndex'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'markAsCompleted'])->name('appointments.complete');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // My Consultations
    Route::get('/consultations', [ConsultationController::class, 'doctorIndex'])->name('consultations.index');
    Route::get('/appointments/{appointment}/consultation/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/appointments/{appointment}/consultation', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::get('/consultations/{consultation}/edit', [ConsultationController::class, 'edit'])->name('consultations.edit');
    Route::put('/consultations/{consultation}', [ConsultationController::class, 'update'])->name('consultations.update');

    // My Prescriptions
    Route::get('/prescriptions', [PrescriptionController::class, 'doctorIndex'])->name('prescriptions.index');
    Route::get('/consultations/{consultation}/prescription/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/consultations/{consultation}/prescription', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
    Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
    Route::get('/prescriptions/{prescription}/download', [PrescriptionController::class, 'download'])->name('prescriptions.download');

    // Doctor Reports
    Route::get('/reports', [ReportController::class, 'doctorIndex'])->name('reports.index');
    Route::get('/reports/patients', [ReportController::class, 'doctorPatients'])->name('reports.patients');
});

// Staff routes
Route::middleware(['auth', 'verified', 'role:Staff'])->prefix('staff')->name('staff.')->group(function () {
    // Staff Dashboard
    Route::get('/dashboard', [DashboardController::class, 'staff'])->name('dashboard');

    // Patient Management
    Route::resource('patients', PatientController::class);

    // Appointment Management
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Billing & Invoices
    Route::get('/invoices', [InvoiceController::class, 'staffIndex'])->name('invoices.index');
    Route::get('/consultations/{consultation}/invoice/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/consultations/{consultation}/invoice', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    // Staff Reports
    Route::get('/reports/billing', [ReportController::class, 'staffBilling'])->name('reports.billing');
});

// Patient/Patient routes
Route::middleware(['auth', 'verified', 'role:Patient'])->prefix('patient')->name('patient.')->group(function () {
    // Patient Dashboard
    Route::get('/dashboard', [DashboardController::class, 'patient'])->name('dashboard');

    // My Profile
    Route::get('/profile', [PatientController::class, 'patientProfile'])->name('profile');

    // My Appointments
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // My Prescriptions
    Route::get('/prescriptions', [PrescriptionController::class, 'patientIndex'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'patientShow'])->name('prescriptions.show');
    Route::get('/prescriptions/{prescription}/download', [PrescriptionController::class, 'download'])->name('prescriptions.download');

    // My Invoices
    Route::get('/invoices', [InvoiceController::class, 'patientIndex'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'patientShow'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
});

// Shared routes (accessible by multiple roles)
Route::middleware(['auth', 'verified'])->group(function () {
    // Quick Actions
    Route::post('/quick-appointment', [AppointmentController::class, 'quickCreate'])->name('quick-appointment.create');
    Route::post('/quick-patient', [PatientController::class, 'quickCreate'])->name('quick-patient.create');

    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');

    Route::delete('/notifications/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->delete();
        return back()->with('success', 'Notification deleted.');
    })->name('notifications.destroy');
});

// Fallback route
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('welcome');
});


// Authentication routes (Breeze)
require __DIR__ . '/auth.php';
