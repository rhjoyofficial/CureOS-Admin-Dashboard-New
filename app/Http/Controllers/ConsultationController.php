<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display a listing of consultations.
     */
    public function index(Request $request)
    {
        $query = Consultation::with(['appointment.patient', 'appointment.doctor']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('appointment.patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('appointment.doctor', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $consultations = $query->latest()->paginate(20);

        return view('admin.consultations.index', compact('consultations'));
    }

    /**
     * Show the form for creating a new consultation.
     */
    public function create()
    {
        // Get completed appointments without consultations
        $availableAppointments = Appointment::where('status', 'completed')
            ->whereDoesntHave('consultation')
            ->with(['patient', 'doctor'])
            ->get();

        return view('admin.consultations.create', compact('availableAppointments'));
    }

    /**
     * Store a newly created consultation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:consultations,appointment_id',
            'visit_notes' => 'required|string',
        ]);

        // Check if appointment exists and is completed
        $appointment = Appointment::findOrFail($request->appointment_id);
        if ($appointment->status !== 'completed') {
            return back()->withErrors(['appointment_id' => 'Only completed appointments can have consultations.'])->withInput();
        }

        Consultation::create([
            'appointment_id' => $request->appointment_id,
            'visit_notes' => $request->visit_notes,
        ]);

        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation created successfully.');
    }

    /**
     * Display the specified consultation.
     */
    public function show(Consultation $consultation)
    {
        $consultation->load(['appointment.patient', 'appointment.doctor', 'prescription.items', 'invoice.items']);
        return view('admin.consultations.show', compact('consultation'));
    }

    /**
     * Show the form for editing the specified consultation.
     */
    public function edit(Consultation $consultation)
    {
        $consultation->load(['appointment']);
        return view('admin.consultations.edit', compact('consultation'));
    }

    /**
     * Update the specified consultation.
     */
    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'visit_notes' => 'required|string',
        ]);

        $consultation->update([
            'visit_notes' => $request->visit_notes,
        ]);

        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified consultation.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation deleted successfully.');
    }
}
