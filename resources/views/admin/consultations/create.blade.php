@extends('layouts.app')

@section('title', 'Add New Consultation')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Add New Consultation</h2>
                <p class="text-sm text-gray-600">Create a new medical consultation</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.consultations.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Appointment Selection -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Select Appointment</h3>

                    @if ($availableAppointments->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <div>
                                    <p class="text-yellow-800 font-medium">No appointments available for consultation</p>
                                    <p class="text-yellow-700 text-sm mt-1">
                                        All completed appointments already have consultations. Please mark an appointment as
                                        completed first.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('admin.appointments.index') }}"
                                class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Go to Appointments
                            </a>
                        </div>
                    @else
                        <div>
                            <label for="appointment_id" class="block text-sm font-medium text-gray-700 mb-1">Appointment
                                *</label>
                            <select name="appointment_id" id="appointment_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Appointment</option>
                                @foreach ($availableAppointments as $appointment)
                                    <option value="{{ $appointment->id }}"
                                        {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                        {{ $appointment->patient->name }} with Dr. {{ $appointment->doctor->name }}
                                        ({{ $appointment->appointment_time->format('M d, Y h:i A') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('appointment_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Consultation Notes -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Consultation Notes</h3>

                    <div>
                        <label for="visit_notes" class="block text-sm font-medium text-gray-700 mb-1">Visit Notes *</label>
                        <textarea name="visit_notes" id="visit_notes" rows="6" required
                            placeholder="Enter detailed consultation notes including symptoms, diagnosis, and recommendations..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('visit_notes') }}</textarea>
                        @error('visit_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Include symptoms, diagnosis, treatment plan, and follow-up recommendations.
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.consultations.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    @if (!$availableAppointments->isEmpty())
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Consultation
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

