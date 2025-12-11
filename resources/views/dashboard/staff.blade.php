@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['todayAppointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- New Patients Today -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">New Patients Today</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['newPatientsToday'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Invoices -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Invoices</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pendingInvoices'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Today's Revenue -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Revenue</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">৳{{ number_format($stats['totalRevenueToday']) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Today's Appointments</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('staff.appointments.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-1"></i> Add Appointment
                    </a>
                    <a href="{{ route('staff.appointments.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        View All
                    </a>
                </div>
            </div>

            @if ($todayAppointments->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500">No appointments scheduled for today</p>
                    <a href="{{ route('staff.appointments.create') }}"
                        class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Schedule First Appointment
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Patient</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Doctor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Phone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($todayAppointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        {{ $appointment->appointment_time->format('h:i A') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-600 text-xs"></i>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $appointment->doctor->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $appointment->patient->phone }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $appointment->status == 'scheduled'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($appointment->status == 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($appointment->status == 'cancelled'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('staff.appointments.show', $appointment) }}"
                                                class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                                View
                                            </a>
                                            @if ($appointment->status == 'scheduled')
                                                <form action="{{ route('staff.appointments.cancel', $appointment) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                        class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Recent Patients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Recent Patients</h3>
                <a href="{{ route('staff.patients.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-1"></i> Add Patient
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recentPatients as $patient)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $patient->name }}</p>
                                <p class="text-sm text-gray-600">{{ $patient->patient_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone-alt w-4 mr-2"></i>
                                <span>{{ $patient->phone }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user-tag w-4 mr-2"></i>
                                <span>{{ $patient->gender }}, {{ $patient->age ?? 'N/A' }} years</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt w-4 mr-2"></i>
                                <span class="truncate">{{ $patient->district ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('staff.patients.show', $patient) }}"
                                class="flex-1 px-3 py-2 text-center text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                View
                            </a>
                            <a href="{{ route('staff.patients.edit', $patient) }}"
                                class="flex-1 px-3 py-2 text-center text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
