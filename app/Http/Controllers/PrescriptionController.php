<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions.
     */
    public function index(Request $request)
    {
        $query = Prescription::with(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('consultation.appointment.patient', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('consultation.appointment.doctor', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $prescriptions = $query->latest()->paginate(20);

        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription.
     */
    public function create()
    {
        // Get consultations without prescriptions
        $availableConsultations = Consultation::whereDoesntHave('prescription')
            ->with(['appointment.patient', 'appointment.doctor'])
            ->get();

        return view('admin.prescriptions.create', compact('availableConsultations'));
    }

    /**
     * Store a newly created prescription.
     */
    public function store(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'notes' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string|max:255',
            'medicines.*.dosage' => 'required|string|max:100',
            'medicines.*.duration' => 'nullable|string|max:100',
            'medicines.*.instructions' => 'nullable|string',
        ]);

        // Check if consultation already has a prescription
        $existingPrescription = Prescription::where('consultation_id', $request->consultation_id)->exists();
        if ($existingPrescription) {
            return back()->withErrors(['consultation_id' => 'This consultation already has a prescription.'])->withInput();
        }

        $prescription = Prescription::create([
            'consultation_id' => $request->consultation_id,
            'notes' => $request->notes,
        ]);

        // Create prescription items
        foreach ($request->medicines as $medicine) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_name' => $medicine['name'],
                'dosage' => $medicine['dosage'],
                'duration' => $medicine['duration'],
                'instructions' => $medicine['instructions'],
            ]);
        }

        return redirect()->route('admin.prescriptions.index')
            ->with('success', 'Prescription created successfully.');
    }

    /**
     * Display the specified prescription.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items']);
        return view('admin.prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified prescription.
     */
    public function edit(Prescription $prescription)
    {
        $prescription->load(['items', 'consultation.appointment.patient', 'consultation.appointment.doctor']);
        return view('admin.prescriptions.edit', compact('prescription'));
    }

    /**
     * Update the specified prescription.
     */
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string|max:255',
            'medicines.*.dosage' => 'required|string|max:100',
            'medicines.*.duration' => 'nullable|string|max:100',
            'medicines.*.instructions' => 'nullable|string',
        ]);

        $prescription->update([
            'notes' => $request->notes,
        ]);

        // Delete existing items and create new ones
        $prescription->items()->delete();
        
        foreach ($request->medicines as $medicine) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_name' => $medicine['name'],
                'dosage' => $medicine['dosage'],
                'duration' => $medicine['duration'],
                'instructions' => $medicine['instructions'],
            ]);
        }

        return redirect()->route('admin.prescriptions.index')
            ->with('success', 'Prescription updated successfully.');
    }

    /**
     * Remove the specified prescription.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('admin.prescriptions.index')
            ->with('success', 'Prescription deleted successfully.');
    }

    /**
     * Download prescription as PDF.
     */
    public function download(Prescription $prescription)
    {
        $prescription->load(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items']);
        
        $pdf = Pdf::loadView('admin.prescriptions.pdf', compact('prescription'));
        
        // Generate filename
        $filename = 'prescription-' . $prescription->id . '-' . date('Y-m-d') . '.pdf';
        
        // Save to storage
        Storage::put('prescriptions/' . $filename, $pdf->output());
        
        // Update prescription with PDF path
        $prescription->update(['pdf_path' => 'prescriptions/' . $filename]);
        
        return $pdf->download($filename);
    }
}