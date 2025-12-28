@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Patients -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['totalPatients'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-injured text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ round(($stats['totalPatients'] / max($stats['totalPatients'], 1)) * 100) }}% from last month
                    </span>
                </div>
            </div>

            <!-- Total Doctors -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Doctors</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['totalDoctors'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-md text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['totalAppointmentsToday'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><span
                                class="font-bengali">৳</span>{{ number_format($stats['totalRevenue']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center text-sm text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ round(($stats['totalRevenue'] / max($stats['totalRevenue'], 1)) * 100) }}% from last month
                    </span>
                </div>
            </div>
        </div>

        <!-- Charts & Recent Data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Monthly Revenue</h3>
                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                        <option>This Year</option>
                        <option>Last Year</option>
                    </select>
                </div>
                <div id="revenueChart" class="h-72"></div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-h-96 overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Appointments</h3>
                    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View All →
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach ($recentAppointments as $appointment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->doctor->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $appointment->appointment_time->format('M d, Y h:i A') }}</p>
                            </div>
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Recent Patients</h3>
                <a href="{{ route('admin.patients.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    View All →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gender</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($recentPatients as $patient)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $patient->patient_id ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $patient->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $patient->phone }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $patient->gender }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $patient->age ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $patient->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Revenue Chart
                const monthlyRevenue = @json($monthlyRevenue);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const revenueData = Array(12).fill(0);

                monthlyRevenue.forEach(item => {
                    revenueData[item.month - 1] = parseFloat(item.total);
                });

                const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), {
                    series: [{
                        name: 'Revenue',
                        data: revenueData
                    }],
                    chart: {
                        type: 'area',
                        height: '100%',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#3B82F6'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.3,
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        categories: months
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        }
                    }
                });

                revenueChart.render();
            });
        </script>
    @endpush
@endsection
