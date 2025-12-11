@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-100">Track your medical appointments, prescriptions, and invoices in one place.</p>
                </div>
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-injured text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Upcoming Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['upcomingAppointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View Schedule →
                    </a>
                </div>
            </div>

            <!-- Completed Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['completedAppointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Prescriptions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Prescriptions</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $recentPrescriptions->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-prescription-bottle-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.prescriptions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View All →
                    </a>
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
                        <i class="fas fa-file-invoice-dollar text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('patient.invoices.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View Invoices →
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('patient.appointments.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-1"></i> Book Appointment
                    </a>
                    <a href="{{ route('patient.appointments.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        View All
                    </a>
                </div>
            </div>

            @if ($upcomingAppointments->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-calendar-plus text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500">No upcoming appointments scheduled</p>
                    <a href="{{ route('patient.appointments.create') }}"
                        class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Book Your First Appointment
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($upcomingAppointments as $appointment)
                        <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user-md text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Dr. {{ $appointment->doctor->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->appointment_time->format('l, F d, Y h:i A') }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-stethoscope mr-1"></i>
                                            {{ $appointment->doctor->specialization ?? 'General Physician' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('patient.appointments.show', $appointment) }}"
                                            class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                            View
                                        </a>
                                        @if ($appointment->status == 'scheduled')
                                            <form action="{{ route('patient.appointments.cancel', $appointment) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                    class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Prescriptions -->
        @if ($recentPrescriptions->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Prescriptions</h3>
                    <a href="{{ route('patient.prescriptions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach ($recentPrescriptions as $prescription)
                        <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <p class="font-medium text-gray-900">Prescription #{{ $prescription->id }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $prescription->created_at->format('M d, Y') }} •
                                        {{ $prescription->items->count() }} medicines
                                    </p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('patient.prescriptions.show', $prescription) }}"
                                        class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                        View Details
                                    </a>
                                    <a href="{{ route('patient.prescriptions.download', $prescription) }}"
                                        class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </div>
                            </div>
                            <div class="space-y-2">
                                @foreach ($prescription->items->take(2) as $item)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-pills text-gray-400 mr-2"></i>
                                        <span>{{ $item->medicine_name }} - {{ $item->dosage }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $item->duration }}</span>
                                    </div>
                                @endforeach
                                @if ($prescription->items->count() > 2)
                                    <p class="text-sm text-gray-500">+{{ $prescription->items->count() - 2 }} more
                                        medicines</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
