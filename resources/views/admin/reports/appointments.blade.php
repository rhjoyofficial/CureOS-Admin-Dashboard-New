@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Appointment Report</h1>
            <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">Back to Reports</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-l-4 border-l-blue-500">
                <p class="text-xs text-gray-500 uppercase font-bold">Total</p>
                <p class="text-2xl font-black">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-l-4 border-l-yellow-500">
                <p class="text-xs text-gray-500 uppercase font-bold">Scheduled</p>
                <p class="text-2xl font-black">{{ $stats['scheduled'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-l-4 border-l-green-500">
                <p class="text-xs text-gray-500 uppercase font-bold">Completed</p>
                <p class="text-2xl font-black">{{ $stats['completed'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-l-4 border-l-red-500">
                <p class="text-xs text-gray-500 uppercase font-bold">Cancelled</p>
                <p class="text-2xl font-black">{{ $stats['cancelled'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Date/Time</th>
                        <th class="p-4 font-semibold text-sm">Patient</th>
                        <th class="p-4 font-semibold text-sm">Doctor</th>
                        <th class="p-4 font-semibold text-sm">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-sm">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('M d, Y h:i A') }}</td>
                            <td class="p-4 text-sm font-medium">{{ $appointment->patient?->name ?? 'N/A' }}</td>
                            <td class="p-4 text-sm italic">Dr. {{ $appointment->doctor?->name ?? 'N/A' }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-bold uppercase 
                            {{ $appointment->status == 'completed' ? 'bg-green-100 text-green-700' : ($appointment->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
