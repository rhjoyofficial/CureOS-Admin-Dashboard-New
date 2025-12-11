@extends('layouts.app')

@section('title', 'Prescription Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Prescription Details</h1>
                        <p class="text-gray-600">Prescription ID: {{ $prescription->id }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.prescriptions.edit', $prescription) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.prescriptions.download', $prescription) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-download mr-1"></i> Download PDF
                        </a>
                        <a href="{{ route('admin.prescriptions.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Prescription Details -->
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
                                <p class="font-bold text-gray-900 text-lg">
                                    {{ $prescription->consultation->appointment->patient->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $prescription->consultation->appointment->patient->phone }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $prescription->consultation->appointment->patient->email ?? 'No email' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->patient->gender }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Age</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->patient->age ?? 'N/A' }} years</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Blood Group</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->patient->blood_group ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Patient ID</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->patient->patient_id ?? 'N/A' }}</p>
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
                                    {{ $prescription->consultation->appointment->doctor->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $prescription->consultation->appointment->doctor->specialization ?? 'General Physician' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $prescription->consultation->appointment->doctor->bmdc_registration ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Consultation Fee</p>
                                <p class="font-medium text-gray-900">
                                    ৳{{ number_format($prescription->consultation->appointment->doctor->consultation_fee ?? 0, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->doctor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Qualifications</p>
                                <p class="font-medium text-gray-900">
                                    {{ $prescription->consultation->appointment->doctor->qualifications ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prescription Notes -->
                @if ($prescription->notes)
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Doctor's Notes & Advice</h3>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="prose max-w-none">
                                {!! nl2br(e($prescription->notes)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Medicines List -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Medicines
                        ({{ $prescription->items->count() }})</h3>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SL</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Medicine Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dosage</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Duration</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Instructions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($prescription->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->medicine_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->dosage }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->duration ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->instructions ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Consultation Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Consultation Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Consultation Date</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $prescription->consultation->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Consultation Time</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $prescription->consultation->created_at->format('h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <a href="{{ route('admin.consultations.show', $prescription->consultation) }}"
                                class="block text-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                View Consultation
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-prescription text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Prescription Created</p>
                                <p class="text-sm text-gray-600">{{ $prescription->created_at->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-history text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Last Updated</p>
                                <p class="text-sm text-gray-600">{{ $prescription->updated_at->format('F d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        @if ($prescription->pdf_path)
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-file-pdf text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">PDF Generated</p>
                                    <p class="text-sm text-gray-600">Available for download</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
