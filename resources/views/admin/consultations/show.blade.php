@extends('layouts.app')

@section('title', 'Consultation Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Consultation Details</h1>
                        <p class="text-gray-600">Consultation ID: {{ $consultation->id }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.consultations.edit', $consultation) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.consultations.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Consultation Details -->
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
                                <p class="font-bold text-gray-900 text-lg">{{ $consultation->appointment->patient->name }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $consultation->appointment->patient->phone }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $consultation->appointment->patient->email ?? 'No email' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-medium text-gray-900">{{ $consultation->appointment->patient->gender }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Age</p>
                                <p class="font-medium text-gray-900">{{ $consultation->appointment->patient->age ?? 'N/A' }}
                                    years</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Blood Group</p>
                                <p class="font-medium text-gray-900">
                                    {{ $consultation->appointment->patient->blood_group ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Patient ID</p>
                                <p class="font-medium text-gray-900">
                                    {{ $consultation->appointment->patient->patient_id ?? 'N/A' }}</p>
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
                                <p class="font-bold text-gray-900 text-lg">Dr.
                                    {{ $consultation->appointment->doctor->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $consultation->appointment->doctor->specialization ?? 'General Physician' }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $consultation->appointment->doctor->bmdc_registration ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Consultation Fee</p>
                                <p class="font-medium text-gray-900">
                                    ৳{{ number_format($consultation->appointment->doctor->consultation_fee ?? 0, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900">
                                    {{ $consultation->appointment->doctor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Qualifications</p>
                                <p class="font-medium text-gray-900">
                                    {{ $consultation->appointment->doctor->qualifications ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Notes -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Consultation Notes</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="prose max-w-none">
                            {!! nl2br(e($consultation->visit_notes)) !!}
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
                                {{ $consultation->appointment->appointment_time->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Appointment Time</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $consultation->appointment->appointment_time->format('h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Appointment Status</p>
                            <p class="font-bold text-gray-900 text-lg">{{ ucfirst($consultation->appointment->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Related Records -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Related Records</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                @if ($consultation->prescription)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Not Created
                                    </span>
                                @endif
                            </div>
                            @if ($consultation->prescription)
                                <a href="{{ route('admin.prescriptions.show', $consultation->prescription) }}"
                                    class="mt-3 block text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    View Prescription
                                </a>
                            @else
                                <a href="{{ route('admin.prescriptions.create') }}?consultation_id={{ $consultation->id }}"
                                    class="mt-3 block text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Create Prescription
                                </a>
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
                                @if ($consultation->invoice)
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $consultation->invoice->payment_status == 'paid'
                                        ? 'bg-green-100 text-green-800'
                                        : ($consultation->invoice->payment_status == 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($consultation->invoice->payment_status == 'partial'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($consultation->invoice->payment_status) }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        Not Created
                                    </span>
                                @endif
                            </div>
                            @if ($consultation->invoice)
                                <a href="{{ route('admin.invoices.show', $consultation->invoice) }}"
                                    class="mt-3 block text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    View Invoice
                                </a>
                            @else
                                <a href="{{ route('admin.invoices.create') }}?consultation_id={{ $consultation->id }}"
                                    class="mt-3 block text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                    Create Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Consultation Created</p>
                                <p class="text-sm text-gray-600">{{ $consultation->created_at->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-history text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-600">{{ $consultation->updated_at->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
