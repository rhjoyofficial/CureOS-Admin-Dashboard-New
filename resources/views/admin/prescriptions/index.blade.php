@extends('layouts.app')

@section('title', 'Prescriptions Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Prescriptions Management</h1>
                <p class="text-gray-600">Manage patient prescriptions</p>
            </div>
            <a href="{{ route('admin.prescriptions.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Prescription
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.prescriptions.index') }}"
                class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by patient, doctor, or medicine..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Date Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.prescriptions.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Prescriptions Table -->
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
                                Medicines</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($prescriptions as $prescription)
                            <tr class="hover:bg-gray-50">
                                <!-- Patient -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                {{ $prescription->consultation->appointment->patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $prescription->consultation->appointment->patient->phone }}</div>
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
                                            <div class="font-medium text-gray-900">Dr.
                                                {{ $prescription->consultation->appointment->doctor->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $prescription->consultation->appointment->doctor->specialization ?? 'General' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Medicines -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $prescription->items->count() }} medicines
                                    </div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">
                                        @foreach ($prescription->items->take(2) as $item)
                                            {{ $item->medicine_name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        @if ($prescription->items->count() > 2)
                                            +{{ $prescription->items->count() - 2 }} more
                                        @endif
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $prescription->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $prescription->created_at->format('h:i A') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.prescriptions.show', $prescription) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.prescriptions.edit', $prescription) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.prescriptions.download', $prescription) }}"
                                            class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg" title="Download PDF">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.prescriptions.destroy', $prescription) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this prescription?')"
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
                                    <i class="fas fa-prescription-bottle-alt text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No prescriptions found</p>
                                    @if (request()->anyFilled(['search', 'date']))
                                        <a href="{{ route('admin.prescriptions.index') }}"
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
            @if ($prescriptions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $prescriptions->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
