@extends('layouts.app')

@section('title', 'Edit Consultation')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Edit Consultation</h2>
                        <p class="text-sm text-gray-600">Update consultation details</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Appointment: {{ $consultation->appointment->patient->name }} with Dr.
                        {{ $consultation->appointment->doctor->name }}
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.consultations.update', $consultation) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Consultation Notes -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Consultation Notes</h3>

                    <div>
                        <label for="visit_notes" class="block text-sm font-medium text-gray-700 mb-1">Visit Notes *</label>
                        <textarea name="visit_notes" id="visit_notes" rows="8" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('visit_notes', $consultation->visit_notes) }}</textarea>
                        @error('visit_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Appointment Information (Read-only) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Appointment Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500">Patient</p>
                            <p class="font-medium text-gray-900">{{ $consultation->appointment->patient->name }}</p>
                            <p class="text-sm text-gray-600">{{ $consultation->appointment->patient->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium text-gray-900">Dr. {{ $consultation->appointment->doctor->name }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $consultation->appointment->doctor->specialization ?? 'General Physician' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Appointment Date</p>
                            <p class="font-medium text-gray-900">
                                {{ $consultation->appointment->appointment_time->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Appointment Time</p>
                            <p class="font-medium text-gray-900">
                                {{ $consultation->appointment->appointment_time->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.consultations.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Consultation
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
