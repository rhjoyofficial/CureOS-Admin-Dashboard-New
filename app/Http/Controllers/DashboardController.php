<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Default dashboard
    public function index()
    {
        $user = auth()->user();

        // Redirect based on primary role
        if ($user->hasRole('Admin')) {
            return $this->admin();
        } elseif ($user->hasRole('Doctor')) {
            return $this->doctor();
        } elseif ($user->hasRole('Staff')) {
            return $this->staff();
        } elseif ($user->hasRole('Patient')) {
            return $this->patient();
        }

        return $this->admin(); // fallback
    }

    // Admin Dashboard
    public function admin()
    {
        $stats = [
            'totalPatients' => Patient::count(),
            'totalDoctors' => User::role('Doctor')->count(),
            'totalAppointmentsToday' => Appointment::today()->count(),
            'pendingAppointments' => Appointment::where('status', 'scheduled')->count(),
            'totalRevenue' => Invoice::where('payment_status', 'paid')->sum('total_amount'),
            'pendingPayments' => Invoice::where('payment_status', 'pending')->sum('total_amount'),
        ];

        $recentAppointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(10)
            ->get();

        $recentPatients = Patient::latest()->take(10)->get();

        // Monthly revenue chart
        $monthlyRevenue = Invoice::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('dashboard.admin', compact('stats', 'recentAppointments', 'recentPatients', 'monthlyRevenue'));
    }

    // Doctor Dashboard
    public function doctor()
    {
        $doctor = auth()->user();

        $stats = [
            'todayAppointments' => Appointment::where('doctor_id', $doctor->id)
                ->today()
                ->count(),
            'totalPatients' => Appointment::where('doctor_id', $doctor->id)
                ->distinct('patient_id')
                ->count('patient_id'),
            'upcomingAppointments' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'scheduled')
                ->where('appointment_time', '>', now())
                ->count(),
            'completedAppointments' => Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'completed')
                ->whereDate('appointment_time', today())
                ->count(),
        ];

        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->today()
            ->orderBy('appointment_time')
            ->get();

        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'scheduled')
            ->where('appointment_time', '>', now())
            ->orderBy('appointment_time')
            ->take(10)
            ->get();

        return view('dashboard.doctor', compact('stats', 'todayAppointments', 'upcomingAppointments'));
    }

    // Staff Dashboard
    public function staff()
    {
        $stats = [
            'todayAppointments' => Appointment::today()->count(),
            'newPatientsToday' => Patient::whereDate('created_at', today())->count(),
            'pendingInvoices' => Invoice::where('payment_status', 'pending')->count(),
            'totalRevenueToday' => Invoice::whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->today()
            ->orderBy('appointment_time')
            ->get();

        $recentPatients = Patient::latest()->take(10)->get();

        return view('dashboard.staff', compact('stats', 'todayAppointments', 'recentPatients'));
    }

    // Patient Dashboard
    // Patient Dashboard
    public function patient()
    {
        // Get the Patient model associated with this user
        $patient = Patient::where('email', auth()->user()->email)->first();

        if (!$patient) {
            // If no patient record found, show empty dashboard
            $stats = [
                'upcomingAppointments' => 0,
                'completedAppointments' => 0,
                'pendingInvoices' => 0,
            ];

            return view('dashboard.patient', compact('stats'));
        }

        $stats = [
            'upcomingAppointments' => Appointment::where('patient_id', $patient->id)
                ->where('status', 'scheduled')
                ->where('appointment_time', '>', now())
                ->count(),
            'completedAppointments' => Appointment::where('patient_id', $patient->id)
                ->where('status', 'completed')
                ->count(),
            'pendingInvoices' => Invoice::whereHas('consultation.appointment', function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
            })
                ->where('payment_status', 'pending')
                ->count(),
        ];

        $upcomingAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('status', 'scheduled')
            ->where('appointment_time', '>', now())
            ->orderBy('appointment_time')
            ->take(10)
            ->get();

        $recentPrescriptions = \App\Models\Prescription::whereHas('consultation.appointment', function ($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.patient', compact('stats', 'upcomingAppointments', 'recentPrescriptions'));
    }
}
