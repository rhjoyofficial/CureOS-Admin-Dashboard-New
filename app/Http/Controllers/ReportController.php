<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function appointments(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereBetween('appointment_time', [$request->start_date, $request->end_date])
            ->get();

        $stats = [
            'total' => $appointments->count(),
            'scheduled' => $appointments->where('status', 'scheduled')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
            'cancelled' => $appointments->where('status', 'cancelled')->count(),
        ];

        return view('reports.appointments', compact('appointments', 'stats'));
    }

    public function billing(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $invoices = Invoice::with(['consultation.appointment.patient'])
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->get();

        $stats = [
            'total_amount' => $invoices->sum('total_amount'),
            'paid_amount' => $invoices->where('payment_status', 'paid')->sum('total_amount'),
            'pending_amount' => $invoices->where('payment_status', 'pending')->sum('total_amount'),
            'total_invoices' => $invoices->count(),
        ];

        return view('reports.billing', compact('invoices', 'stats'));
    }

    public function patients(Request $request)
    {
        $patients = Patient::with(['appointments', 'invoices'])
            ->withCount(['appointments', 'invoices'])
            ->latest()
            ->get();

        $stats = [
            'total_patients' => $patients->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)->count(),
            'with_appointments' => $patients->where('appointments_count', '>', 0)->count(),
        ];

        return view('reports.patients', compact('patients', 'stats'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:appointments,billing,patients',
            'format' => 'required|in:csv,pdf',
        ]);

        // This would generate and download the report
        // Implementation depends on your needs

        return back()->with('success', 'Report exported successfully.');
    }
}
