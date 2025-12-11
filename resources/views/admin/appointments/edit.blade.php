@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Edit Appointment</h2>
                <p class="text-sm text-gray-600">Update appointment details</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient -->
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient *</label>
                        <select name="patient_id" id="patient_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Patient</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Doctor *</label>
                        <select name="doctor_id" id="doctor_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointment Time -->
                    <div class="md:col-span-2">
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-1">Appointment Date
                            & Time *</label>
                        <input type="datetime-local" name="appointment_time" id="appointment_time"
                            value="{{ old('appointment_time', $appointment->appointment_time->format('Y-m-d\TH:i')) }}"
                            required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('appointment_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                        <select name="status" id="status" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Status</option>
                            <option value="scheduled"
                                {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled
                            </option>
                            <option value="completed"
                                {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled"
                                {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="no_show"
                                {{ old('status', $appointment->status) == 'no_show' ? 'selected' : '' }}>No Show</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.appointments.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
