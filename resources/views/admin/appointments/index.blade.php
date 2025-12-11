@extends('layouts.app')

@section('title', 'Appointments Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Appointments Management</h1>
                <p class="text-gray-600">Manage patient appointments</p>
            </div>
            <a href="{{ route('admin.appointments.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Appointment
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.appointments.index') }}"
                class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by patient, doctor, or phone..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                        <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Doctor Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                    <select name="doctor_id"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Doctors</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.appointments.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Appointments Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Appointment Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <!-- Patient -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $appointment->patient->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->patient->phone }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Doctor -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-md text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Dr. {{ $appointment->doctor->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $appointment->doctor->specialization ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Appointment Time -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appointment->appointment_time->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $appointment->appointment_time->format('h:i A') }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $appointment->appointment_time->diffForHumans() }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $appointment->status == 'scheduled'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($appointment->status == 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($appointment->status == 'cancelled'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if ($appointment->status == 'scheduled')
                                            <form action="{{ route('admin.appointments.complete', $appointment) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Mark this appointment as completed?')"
                                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg"
                                                    title="Mark as Completed">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.appointments.cancel', $appointment) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Cancel this appointment?')"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Cancel">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this appointment?')"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No appointments found</p>
                                    @if (request()->anyFilled(['search', 'status', 'date', 'doctor_id']))
                                        <a href="{{ route('admin.appointments.index') }}"
                                            class="mt-2 inline-block text-blue-600 hover:text-blue-800">
                                            Clear filters
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($appointments->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $appointments->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
