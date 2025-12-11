@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Today's Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $data['totalAppointmentsToday'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Patients</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $data['totalPatients'] }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-user-injured text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($data['totalRevenue'], 2) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Pending Appointments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $data['pendingAppointments'] }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role-specific sections -->
        @if (auth()->user()->hasRole('Doctor'))
            <!-- Doctor Dashboard -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">My Upcoming Appointments</h3>
                </div>
                <div class="p-6">
                    @if (isset($data['myAppointments']) && $data['myAppointments']->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Time</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($data['myAppointments'] as $appointment)
                                        <tr>
                                            <td class="px-4 py-3">{{ $appointment->patient->name }}</td>
                                            <td class="px-4 py-3">
                                                {{ $appointment->appointment_time->format('M d, Y h:i A') }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full {{ $appointment->status == 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('appointments.show', $appointment) }}"
                                                    class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No upcoming appointments.</p>
                    @endif
                </div>
            </div>
        @endif

        @if (auth()->user()->hasRole('Admin'))
            <!-- Admin Dashboard -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Appointments -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Appointments</h3>
                    </div>
                    <div class="p-6">
                        @if (isset($data['recentAppointments']) && $data['recentAppointments']->count() > 0)
                            <div class="space-y-4">
                                @foreach ($data['recentAppointments'] as $appointment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium">{{ $appointment->patient->name }}</p>
                                            <p class="text-sm text-gray-600">Dr. {{ $appointment->doctor->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $appointment->appointment_time->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $appointment->status == 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No recent appointments.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Patients -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Patients</h3>
                    </div>
                    <div class="p-6">
                        @if (isset($data['recentPatients']) && $data['recentPatients']->count() > 0)
                            <div class="space-y-4">
                                @foreach ($data['recentPatients'] as $patient)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $patient->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $patient->phone }}</p>
                                            <p class="text-xs text-gray-500">{{ $patient->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No recent patients.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
