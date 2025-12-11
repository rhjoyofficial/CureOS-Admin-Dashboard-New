@extends('layouts.app')

@section('title', 'Patient Details: ' . $patient->name)

@section('content')
    <div class="max-w-8xl mx-auto">
        <!-- Patient Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-injured text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $patient->name }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span
                                    class="px-3 py-1 text-sm font-medium rounded-full 
                                {{ $patient->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($patient->status) }}
                                </span>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    ID: {{ $patient->patient_id ?? 'N/A' }}
                                </span>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                    {{ $patient->gender }}, {{ $patient->age ?? 'N/A' }} years
                                </span>
                                @if ($patient->blood_group)
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                                        Blood: {{ $patient->blood_group }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.patients.edit', $patient) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.patients.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Patient Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Phone Number</p>
                                <p class="font-medium text-gray-900">{{ $patient->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email Address</p>
                                <p class="font-medium text-gray-900">{{ $patient->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">National ID (NID)</p>
                                <p class="font-medium text-gray-900">{{ $patient->nid ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="font-medium text-gray-900">
                                    {{ $patient->date_of_birth ? $patient->date_of_birth->format('F d, Y') : 'N/A' }}
                                    @if ($patient->date_of_birth)
                                        <span class="text-gray-500">({{ $patient->age }} years)</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Occupation</p>
                                <p class="font-medium text-gray-900">{{ $patient->occupation ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Birth Certificate</p>
                                <p class="font-medium text-gray-900">{{ $patient->birth_certificate_no ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Address Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Division</p>
                                <p class="font-medium text-gray-900">{{ $patient->division ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">District</p>
                                <p class="font-medium text-gray-900">{{ $patient->district ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Upazila</p>
                                <p class="font-medium text-gray-900">{{ $patient->upazila ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Union</p>
                                <p class="font-medium text-gray-900">{{ $patient->union ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Village</p>
                                <p class="font-medium text-gray-900">{{ $patient->village ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Post Office</p>
                                <p class="font-medium text-gray-900">{{ $patient->post_office ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Post Code</p>
                                <p class="font-medium text-gray-900">{{ $patient->post_code ?? 'N/A' }}</p>
                            </div>
                            @if ($patient->full_address)
                                <div class="md:col-span-2">
                                    <p class="text-sm text-gray-500">Full Address</p>
                                    <p class="font-medium text-gray-900">{{ $patient->full_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Family Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Family Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Father's Name</p>
                                <p class="font-medium text-gray-900">{{ $patient->father_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Mother's Name</p>
                                <p class="font-medium text-gray-900">{{ $patient->mother_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Husband/Wife Name</p>
                                <p class="font-medium text-gray-900">{{ $patient->husband_wife_name ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Marital Status</p>
                                    <p class="font-medium text-gray-900">{{ $patient->marital_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Religion</p>
                                    <p class="font-medium text-gray-900">{{ $patient->religion ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical History -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Medical History</h3>
                    <div class="space-y-4">
                        @if ($patient->allergies)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Allergies</p>
                                <p class="font-medium text-gray-900">{{ $patient->allergies }}</p>
                            </div>
                        @endif
                        @if ($patient->current_medications)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Current Medications</p>
                                <p class="font-medium text-gray-900">{{ $patient->current_medications }}</p>
                            </div>
                        @endif
                        @if ($patient->past_medical_history)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Past Medical History</p>
                                <p class="font-medium text-gray-900">{{ $patient->past_medical_history }}</p>
                            </div>
                        @endif
                        @if ($patient->family_medical_history)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Family Medical History</p>
                                <p class="font-medium text-gray-900">{{ $patient->family_medical_history }}</p>
                            </div>
                        @endif
                        @if ($patient->habits)
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Habits</p>
                                <p class="font-medium text-gray-900">{{ $patient->habits }}</p>
                            </div>
                        @endif
                        @if (
                            !$patient->allergies &&
                                !$patient->current_medications &&
                                !$patient->past_medical_history &&
                                !$patient->family_medical_history &&
                                !$patient->habits)
                            <p class="text-gray-500 italic">No medical history recorded</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats & Additional Info -->
            <div class="space-y-6">
                <!-- Emergency Contact -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Emergency Contact</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Contact Person</p>
                            <p class="font-medium text-gray-900">{{ $patient->emergency_contact_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium text-gray-900">{{ $patient->emergency_contact_phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Relation</p>
                            <p class="font-medium text-gray-900">{{ $patient->emergency_contact_relation ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Created By</p>
                            <p class="font-medium text-gray-900">{{ $patient->creator->name ?? 'System' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Created At</p>
                            <p class="font-medium text-gray-900">{{ $patient->created_at->format('F d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Last Updated</p>
                            <p class="font-medium text-gray-900">{{ $patient->updated_at->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Medical Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-check text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Appointments</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $patient->appointments->count() }}</p>
                                </div>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">
                                View All
                            </a>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-file-prescription text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Prescriptions</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $patient->prescriptions->count() }}</p>
                                </div>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">
                                View All
                            </a>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-file-invoice-dollar text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Consultations</p>
                                    <p class="text-xl font-bold text-gray-900">{{ $patient->consultations->count() }}</p>
                                </div>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">
                                View All
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                @if ($patient->appointments->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">Recent Appointments</h3>
                        <div class="space-y-3">
                            @foreach ($patient->appointments->take(3) as $appointment)
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900">Dr. {{ $appointment->doctor->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $appointment->appointment_time->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $appointment->status == 'scheduled'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($appointment->status == 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($appointment->status == 'cancelled'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($patient->appointments->count() > 3)
                            <a href="#" class="mt-4 block text-center text-blue-600 hover:text-blue-800 text-sm">
                                View All {{ $patient->appointments->count() }} Appointments
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
