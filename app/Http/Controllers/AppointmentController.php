<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        // 1. Search functionality (scoped to ensure OR logic doesn't break other filters)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->whereHas('patient', function ($p) use ($search) {
                    $p->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('doctor', function ($d) use ($search) {
                    $d->where('name', 'like', "%{$search}%");
                });
            });
        });

        // 2. Filter by status
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // 3. Filter by date
        $query->when($request->filled('date'), function ($q) use ($request) {
            $q->whereDate('appointment_time', $request->date);
        });

        // 4. Filter by doctor
        $query->when($request->filled('doctor_id'), function ($q) use ($request) {
            $q->where('doctor_id', $request->doctor_id);
        });

        $appointments = $query->latest()->paginate(20)->withQueryString();

        $doctors = User::role('Doctor')->active()->get();
        $patients = Patient::active()->get();

        return view('admin.appointments.index', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $patients = Patient::active()->get();
        $doctors = User::role('Doctor')->active()->get();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_time' => 'required|date|after:now',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
        ]);

        // Check if time slot is available
        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_time', $request->appointment_time)
            ->where('status', 'scheduled')
            ->exists();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked for the selected doctor.'])->withInput();
        }

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'consultation']);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::active()->get();
        $doctors = User::role('Doctor')->active()->get();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified appointment.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_time' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
        ]);

        // Check if time slot is available (exclude current appointment)
        if ($appointment->status === 'scheduled') {
            $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_time', $request->appointment_time)
                ->where('status', 'scheduled')
                ->where('id', '!=', $appointment->id)
                ->exists();

            if ($existingAppointment) {
                return back()->withErrors(['appointment_time' => 'This time slot is already booked for the selected doctor.'])->withInput();
            }
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified appointment.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Mark appointment as completed.
     */
    public function markAsCompleted(Appointment $appointment)
    {
        $appointment->update(['status' => 'completed']);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment marked as completed.');
    }

    /**
     * Cancel appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
