@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Appointment Details</h1>
                        <p class="text-gray-600">Appointment ID: {{ $appointment->id }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span
                            class="px-3 py-1 text-sm font-medium rounded-full 
                        {{ $appointment->status == 'scheduled'
                            ? 'bg-blue-100 text-blue-800'
                            : ($appointment->status == 'completed'
                                ? 'bg-green-100 text-green-800'
                                : ($appointment->status == 'cancelled'
                                    ? 'bg-red-100 text-red-800'
                                    : 'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                        </span>
                        <a href="{{ route('admin.appointments.edit', $appointment) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="p-6 space-y-8">
                <!-- Patient & Doctor Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Patient Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Patient Information</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ $appointment->patient->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->patient->phone }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->patient->email ?? 'No email' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-medium text-gray-900">{{ $appointment->patient->gender }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Age</p>
                                <p class="font-medium text-gray-900">{{ $appointment->patient->age ?? 'N/A' }} years</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Blood Group</p>
                                <p class="font-medium text-gray-900">{{ $appointment->patient->blood_group ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Patient ID</p>
                                <p class="font-medium text-gray-900">{{ $appointment->patient->patient_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Doctor Information</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">Dr. {{ $appointment->doctor->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $appointment->doctor->specialization ?? 'General Physician' }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->doctor->bmdc_registration ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Consultation Fee</p>
                                <p class="font-medium text-gray-900">
                                    <span
                                        class="font-bengali">৳</span>{{ number_format($appointment->doctor->consultation_fee ?? 0, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900">{{ $appointment->doctor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Qualifications</p>
                                <p class="font-medium text-gray-900">{{ $appointment->doctor->qualifications ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Appointment Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Appointment Date</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $appointment->appointment_time->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Appointment Time</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $appointment->appointment_time->format('h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $appointment->appointment_time->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Appointment Timeline -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Appointment Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Appointment Created</p>
                                <p class="text-sm text-gray-600">{{ $appointment->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Appointment Scheduled For</p>
                                <p class="text-sm text-gray-600">
                                    {{ $appointment->appointment_time->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-history text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-600">{{ $appointment->updated_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Records -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Related Records</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Consultation -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-stethoscope text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Consultation</p>
                                        <p class="text-sm text-gray-600">Medical Consultation</p>
                                    </div>
                                </div>
                                @if ($appointment->consultation)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Not Created
                                    </span>
                                @endif
                            </div>
                            @if ($appointment->consultation)
                                <a href="{{ route('admin.consultations.show', $appointment->consultation) }}"
                                    class="mt-3 block text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    View Consultation
                                </a>
                            @else
                                <a href="{{ route('admin.consultations.create') }}?appointment_id={{ $appointment->id }}"
                                    class="mt-3 block text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Create Consultation
                                </a>
                            @endif
                        </div>

                        <!-- Prescription -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-prescription-bottle-alt text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Prescription</p>
                                        <p class="text-sm text-gray-600">Medicines & Advice</p>
                                    </div>
                                </div>
                                @if ($appointment->consultation && $appointment->consultation->prescription)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Not Created
                                    </span>
                                @endif
                            </div>
                            @if ($appointment->consultation && $appointment->consultation->prescription)
                                <a href="{{ route('admin.prescriptions.show', $appointment->consultation->prescription) }}"
                                    class="mt-3 block text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    View Prescription
                                </a>
                            @elseif($appointment->consultation)
                                <a href="{{ route('admin.prescriptions.create') }}?consultation_id={{ $appointment->consultation->id }}"
                                    class="mt-3 block text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Create Prescription
                                </a>
                            @else
                                <button disabled
                                    class="mt-3 block w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                    Create Consultation First
                                </button>
                            @endif
                        </div>

                        <!-- Invoice -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-file-invoice-dollar text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Invoice</p>
                                        <p class="text-sm text-gray-600">Billing & Payment</p>
                                    </div>
                                </div>
                                @if ($appointment->consultation && $appointment->consultation->invoice)
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $appointment->consultation->invoice->payment_status == 'paid'
                                        ? 'bg-green-100 text-green-800'
                                        : ($appointment->consultation->invoice->payment_status == 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($appointment->consultation->invoice->payment_status == 'partial'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($appointment->consultation->invoice->payment_status) }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Not Created
                                    </span>
                                @endif
                            </div>
                            @if ($appointment->consultation && $appointment->consultation->invoice)
                                <a href="{{ route('admin.invoices.show', $appointment->consultation->invoice) }}"
                                    class="mt-3 block text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    View Invoice
                                </a>
                            @elseif($appointment->consultation)
                                <a href="{{ route('admin.invoices.create') }}?consultation_id={{ $appointment->consultation->id }}"
                                    class="mt-3 block text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    Create Invoice
                                </a>
                            @else
                                <button disabled
                                    class="mt-3 block w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                    Create Consultation First
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if ($appointment->status == 'scheduled')
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                            <form action="{{ route('admin.appointments.complete', $appointment) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Mark this appointment as completed?')"
                                    class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                                </button>
                            </form>

                            <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST"
                                class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Cancel this appointment?')"
                                    class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    <i class="fas fa-times-circle mr-2"></i> Cancel Appointment
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
