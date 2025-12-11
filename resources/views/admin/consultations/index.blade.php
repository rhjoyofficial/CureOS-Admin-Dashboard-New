@extends('layouts.app')

@section('title', 'Consultations Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Consultations Management</h1>
                <p class="text-gray-600">Manage patient consultations</p>
            </div>
            <a href="{{ route('admin.consultations.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Consultation
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.consultations.index') }}"
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
                    <a href="{{ route('admin.consultations.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Consultations Table -->
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
                                Consultation Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($consultations as $consultation)
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
                                                {{ $consultation->appointment->patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $consultation->appointment->patient->phone }}</div>
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
                                                {{ $consultation->appointment->doctor->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $consultation->appointment->doctor->specialization ?? 'General' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Consultation Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $consultation->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $consultation->created_at->format('h:i A') }}
                                    </div>
                                </td>

                                <!-- Notes -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 truncate max-w-xs">
                                        {{ Str::limit($consultation->visit_notes, 50) }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.consultations.show', $consultation) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.consultations.edit', $consultation) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.consultations.destroy', $consultation) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this consultation?')"
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
                                    <i class="fas fa-stethoscope text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No consultations found</p>
                                    @if (request()->anyFilled(['search', 'date']))
                                        <a href="{{ route('admin.consultations.index') }}"
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
            @if ($consultations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $consultations->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
