<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index(Request $request)
    {
        $query = Patient::with('creator');

        // Search functionality
        $query->when($request->search, function ($q, $search) {
            $q->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('patient_id', 'like', "%{$search}%")
                    ->orWhere('nid', 'like', "%{$search}%");
            });
        });

        // Filter by status (Only applies if status is not empty)
        $query->when($request->status, function ($q, $status) {
            $q->where('status', $status);
        });

        // Filter by gender (Only applies if gender is not empty)
        $query->when($request->gender, function ($q, $gender) {
            $q->where('gender', $gender);
        });

        // Filter by district (Only applies if district is not empty)
        $query->when($request->district, function ($q, $district) {
            $q->where('district', $district);
        });

        $patients = $query->latest()->paginate(20)->withQueryString();

        // Optimize: Get unique districts only from existing patients
        $districts = Patient::whereNotNull('district')
            ->distinct()
            ->pluck('district');

        return view('admin.patients.index', compact('patients', 'districts'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created patient.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients',
            'email' => 'nullable|email|max:255|unique:patients',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'husband_wife_name' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:100',
            'division' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'union' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'post_office' => 'nullable|string|max:100',
            'post_code' => 'nullable|string|max:10',
            'full_address' => 'nullable|string',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown',
            'marital_status' => 'nullable|in:Unmarried,Married,Divorced,Widowed',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism,Other',
            'nationality' => 'nullable|string|max:50',
            'nid' => 'nullable|string|max:30|unique:patients',
            'birth_certificate_no' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:50',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_medical_history' => 'nullable|string',
            'habits' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $patient = Patient::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'husband_wife_name' => $request->husband_wife_name,
            'occupation' => $request->occupation,
            'division' => $request->division,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'union' => $request->union,
            'village' => $request->village,
            'post_office' => $request->post_office,
            'post_code' => $request->post_code,
            'full_address' => $request->full_address,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'nationality' => $request->nationality ?? 'Bangladeshi',
            'nid' => $request->nid,
            'birth_certificate_no' => $request->birth_certificate_no,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'emergency_contact_relation' => $request->emergency_contact_relation,
            'allergies' => $request->allergies,
            'current_medications' => $request->current_medications,
            'past_medical_history' => $request->past_medical_history,
            'family_medical_history' => $request->family_medical_history,
            'habits' => $request->habits,
            'created_by' => Auth::id(),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified patient.
     */
    public function show(Patient $patient)
    {
        // Load the full chain to get to prescriptions
        $patient->load([
            'creator',
            'appointments.doctor',
            'appointments.consultation.prescription'
        ]);

        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', Rule::unique('patients')->ignore($patient->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('patients')->ignore($patient->id)],
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'husband_wife_name' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:100',
            'division' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'upazila' => 'nullable|string|max:100',
            'union' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'post_office' => 'nullable|string|max:100',
            'post_code' => 'nullable|string|max:10',
            'full_address' => 'nullable|string',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown',
            'marital_status' => 'nullable|in:Unmarried,Married,Divorced,Widowed',
            'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism,Other',
            'nationality' => 'nullable|string|max:50',
            'nid' => ['nullable', 'string', 'max:30', Rule::unique('patients')->ignore($patient->id)],
            'birth_certificate_no' => 'nullable|string|max:50',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:50',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'family_medical_history' => 'nullable|string',
            'habits' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $patient->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'husband_wife_name' => $request->husband_wife_name,
            'occupation' => $request->occupation,
            'division' => $request->division,
            'district' => $request->district,
            'upazila' => $request->upazila,
            'union' => $request->union,
            'village' => $request->village,
            'post_office' => $request->post_office,
            'post_code' => $request->post_code,
            'full_address' => $request->full_address,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'nationality' => $request->nationality,
            'nid' => $request->nid,
            'birth_certificate_no' => $request->birth_certificate_no,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'emergency_contact_relation' => $request->emergency_contact_relation,
            'allergies' => $request->allergies,
            'current_medications' => $request->current_medications,
            'past_medical_history' => $request->past_medical_history,
            'family_medical_history' => $request->family_medical_history,
            'habits' => $request->habits,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
