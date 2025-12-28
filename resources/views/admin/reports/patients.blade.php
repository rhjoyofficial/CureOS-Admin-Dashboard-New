@extends('layouts.app')

@section('title', 'Patient Analysis Report')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Patient Analysis Report</h1>
                <p class="text-gray-600">Overview of patient registrations and engagement levels.</p>
            </div>
            <a href="{{ route('admin.reports.index') }}"
                class="flex items-center text-blue-600 hover:text-blue-800 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Database</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_patients']) }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg text-purple-600">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">New This Month</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['new_this_month']) }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg text-blue-600">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Active Patients</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['with_appointments']) }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg text-green-600">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b bg-gray-50">
                <h2 class="font-bold text-gray-700">Patient Engagement Detail</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase">Patient Name</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase">Registered</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase">Appts.</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase">Total Billed</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-600 uppercase">Engagement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($patients as $patient)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $patient->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $patient->phone }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $patient->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-bold">
                                        {{ $patient->appointments_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                    <span
                                        class="font-bengali">৳</span>{{ number_format($patient->invoices->sum('total_amount'), 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($patient->appointments_count > 5)
                                        <span
                                            class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-bold">VIP</span>
                                    @elseif($patient->appointments_count > 0)
                                        <span
                                            class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full font-bold">Regular</span>
                                    @else
                                        <span
                                            class="text-xs px-2 py-1 bg-gray-100 text-gray-500 rounded-full font-bold">New</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                    No patient records available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
