<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Fetching high-level stats for the dashboard cards
        $quickStats = [
            'total_appointments' => Appointment::count(),
            'total_revenue' => Invoice::where('payment_status', 'paid')->sum('total_amount'),
            'total_patients' => Patient::count(),
            'recent_activity' => Appointment::with('patient')->latest()->take(5)->get()
        ];

        return view('admin.reports.index', compact('quickStats'));
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

        return view('admin.reports.appointments', compact('appointments', 'stats'));
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

        return view('admin.reports.billing', compact('invoices', 'stats'));
    }

    public function patients(Request $request)
    {
        $patients = Patient::withCount(['appointments'])
            ->addSelect(['invoices_count' => Invoice::whereHas('consultation.appointment', function ($q) {
                $q->whereColumn('patient_id', 'patients.id');
            })->selectRaw('count(*)')])
            ->latest()
            ->get();

        // Calculate stats using the subquery result
        $stats = [
            'total_patients' => $patients->count(),
            'new_this_month' => Patient::whereMonth('created_at', now()->month)->count(),
            'with_appointments' => $patients->where('appointments_count', '>', 0)->count(),
        ];

        return view('admin.reports.patients', compact('patients', 'stats'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:appointments,billing,patients',
            'format' => 'required|in:csv,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now();

        // 1. Fetch Data based on type
        if ($request->type === 'appointments') {
            $data = Appointment::with(['patient', 'doctor'])
                ->whereBetween('appointment_time', [$startDate, $endDate])->get();
            $view = 'admin.reports.pdf.appointments'; // Create this simple blade for PDF layout
        } elseif ($request->type === 'billing') {
            $data = Invoice::with(['consultation.appointment.patient'])
                ->whereBetween('created_at', [$startDate, $endDate])->get();
            $view = 'admin.reports.pdf.billing';
        } else {
            $data = Patient::all();
            $view = 'admin.reports.pdf.patients';
        }

        // 2. Handle CSV Export
        if ($request->format === 'csv') {
            $fileName = $request->type . '_report.csv';
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function () use ($data, $request) {
                $file = fopen('php://output', 'w');

                // CSV Headers based on type
                if ($request->type === 'appointments') {
                    fputcsv($file, ['ID', 'Date', 'Patient', 'Doctor', 'Status']);
                    foreach ($data as $row) {
                        fputcsv($file, [$row->id, $row->appointment_time, $row->patient?->name, $row->doctor?->name, $row->status]);
                    }
                }
                // ... add logic for other types ...

                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }

        // 3. Handle PDF Export (DomPDF)
        $pdf = Pdf::loadView($view, ['data' => $data, 'start' => $startDate, 'end' => $endDate]);
        return $pdf->download($request->type . '_report.pdf');
    }
}
