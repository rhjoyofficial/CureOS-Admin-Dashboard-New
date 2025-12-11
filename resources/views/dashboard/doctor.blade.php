@extends('layouts.app')

@section('title', 'Doctor Dashboard')

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
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['totalPatients'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-friends text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Upcoming Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['upcomingAppointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Completed Today -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed Today</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['completedAppointments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule & Upcoming Appointments -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Today's Schedule -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Today's Schedule</h3>
                    <span class="text-sm text-gray-500">{{ now()->format('F d, Y') }}</span>
                </div>
                <div class="space-y-4">
                    @if ($todayAppointments->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">No appointments scheduled for today</p>
                        </div>
                    @else
                        @foreach ($todayAppointments as $appointment)
                            <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $appointment->appointment_time->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('doctor.appointments.show', $appointment) }}"
                                            class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                            View
                                        </a>
                                        @if ($appointment->status == 'scheduled')
                                            <form action="{{ route('doctor.appointments.complete', $appointment) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                                    Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                    <a href="{{ route('doctor.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @if ($upcomingAppointments->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-plus text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500">No upcoming appointments</p>
                        </div>
                    @else
                        @foreach ($upcomingAppointments as $appointment)
                            <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->appointment_time->format('M d, Y h:i A') }}</p>
                                        <span class="inline-flex items-center mt-2 text-sm text-gray-500">
                                            <i class="fas fa-phone-alt mr-1 text-xs"></i>
                                            {{ $appointment->patient->phone }}
                                        </span>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('doctor.appointments.show', $appointment) }}"
                                        class="flex-1 px-3 py-2 text-center text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                        View Details
                                    </a>
                                    @if ($appointment->status == 'scheduled')
                                        <form action="{{ route('doctor.appointments.cancel', $appointment) }}"
                                            method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                class="w-full px-3 py-2 text-sm bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
