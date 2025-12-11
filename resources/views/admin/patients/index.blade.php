@extends('layouts.app')

@section('title', 'Patients Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Patients Management</h1>
                <p class="text-gray-600">Manage patient records and information</p>
            </div>
            <a href="{{ route('admin.patients.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Patient
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.patients.index') }}"
                class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, phone, email, or ID..."
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
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Gender Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Gender</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- District Filter -->
                @if ($districts->isNotEmpty())
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <select name="district"
                            class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Districts</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}"
                                    {{ request('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.patients.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <!-- Patient ID -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-blue-600">{{ $patient->patient_id ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">ID: {{ $patient->id }}</div>
                                </td>

                                <!-- Patient Details -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $patient->gender }}, {{ $patient->age ?? 'N/A' }} years
                                                @if ($patient->date_of_birth)
                                                    <span
                                                        class="ml-2">({{ $patient->date_of_birth->format('M d, Y') }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $patient->phone }}</div>
                                    <div class="text-sm text-gray-500">{{ $patient->email ?? 'No email' }}</div>
                                </td>

                                <!-- Address -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $patient->district ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $patient->upazila ?? 'N/A' }}</div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $patient->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.patients.show', $patient) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.patients.edit', $patient) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this patient? This action cannot be undone.')"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <i class="fas fa-user-injured text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No patients found</p>
                                    @if (request()->anyFilled(['search', 'status', 'gender', 'district']))
                                        <a href="{{ route('admin.patients.index') }}"
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
            @if ($patients->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $patients->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
