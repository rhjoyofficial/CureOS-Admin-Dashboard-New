@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Reports Dashboard</h1>
                <p class="text-gray-600">Overview and data extraction center</p>
            </div>
            <div class="text-right">
                <span class="text-sm font-medium text-gray-500">Current Date</span>
                <p class="font-bold text-gray-900">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-semibold">Total Revenue</p>
                <p class="text-3xl font-black text-green-600"><span
                        class="font-bengali">৳</span>{{ number_format($quickStats['total_revenue'], 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-semibold">Total Patients</p>
                <p class="text-3xl font-black text-blue-600">{{ $quickStats['total_patients'] }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-semibold">System Appointments</p>
                <p class="text-3xl font-black text-purple-600">{{ $quickStats['total_appointments'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Generate Interactive Reports</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.reports.appointments') }}?start_date={{ now()->startOfMonth()->toDateString() }}&end_date={{ now()->toDateString() }}"
                        class="group p-6 bg-white border rounded-xl hover:border-blue-500 transition shadow-sm">
                        <i class="fas fa-calendar-alt text-blue-500 text-2xl mb-3"></i>
                        <h3 class="font-bold group-hover:text-blue-600">Appointments Analysis</h3>
                        <p class="text-sm text-gray-500">View detailed visit logs and doctor schedules.</p>
                    </a>

                    <a href="{{ route('admin.reports.billing') }}?start_date={{ now()->startOfMonth()->toDateString() }}&end_date={{ now()->toDateString() }}"
                        class="group p-6 bg-white border rounded-xl hover:border-green-500 transition shadow-sm">
                        <i class="fas fa-file-invoice-dollar text-green-500 text-2xl mb-3"></i>
                        <h3 class="font-bold group-hover:text-green-600">Billing & Revenue</h3>
                        <p class="text-sm text-gray-500">Financial breakdown and unpaid invoice tracking.</p>
                    </a>
                </div>
            </div>

            <div class="bg-gray-900 text-white rounded-2xl p-6 shadow-xl">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-file-export mr-2 text-yellow-400"></i> Data Export Center
                </h2>
                <p class="text-gray-400 text-sm mb-6">Download your data in CSV or PDF format for offline use.</p>

                <form action="{{ route('admin.reports.export') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Report Type</label>
                        <select name="type"
                            class="w-full bg-gray-800 border-gray-700 rounded-lg text-sm focus:ring-yellow-500">
                            <option value="appointments">Appointments Report</option>
                            <option value="billing">Billing/Financial Report</option>
                            <option value="patients">Patient Database</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Start Date</label>
                            <input type="date" name="start_date" value="{{ now()->startOfMonth()->toDateString() }}"
                                class="w-full bg-gray-800 border-gray-700 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ now()->toDateString() }}"
                                class="w-full bg-gray-800 border-gray-700 rounded-lg text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Format</label>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="format" value="csv" checked class="text-yellow-500">
                                <span class="ml-2 text-sm">Excel (CSV)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="format" value="pdf" class="text-yellow-500">
                                <span class="ml-2 text-sm">PDF Document</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-xl transition mt-4">
                        Generate & Download
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
