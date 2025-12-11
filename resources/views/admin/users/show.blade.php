@extends('layouts.app')

@section('title', 'User Details: ' . $user->name)

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <div class="flex items-center space-x-3 mt-1">
                                <span
                                    class="px-3 py-1 text-sm font-medium rounded-full 
                                {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($user->roles->first()->name ?? 'No Role') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="p-6 space-y-8">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Contact Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-id-card text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">National ID (NID)</p>
                                    <p class="font-medium text-gray-900">{{ $user->nid ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-birthday-cake text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Date of Birth</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $user->date_of_birth ? $user->date_of_birth->format('F d, Y') : 'N/A' }}
                                        @if ($user->date_of_birth)
                                            <span class="text-gray-500">({{ $user->date_of_birth->age }} years)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tint text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Blood Group</p>
                                    <p class="font-medium text-gray-900">{{ $user->blood_group ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Address Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">District</p>
                                    <p class="font-medium text-gray-900">{{ $user->district ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marked-alt text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Upazila</p>
                                    <p class="font-medium text-gray-900">{{ $user->upazila ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-home text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Village</p>
                                    <p class="font-medium text-gray-900">{{ $user->village ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-mail-bulk text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Post Office & Code</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $user->post_office ?? 'N/A' }}
                                        @if ($user->post_code)
                                            - {{ $user->post_code }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone-square-alt text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Emergency Contact</p>
                                    <p class="font-medium text-gray-900">{{ $user->emergency_contact ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Family Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Family Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-male text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Father's Name</p>
                                    <p class="font-medium text-gray-900">{{ $user->father_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-female text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Mother's Name</p>
                                    <p class="font-medium text-gray-900">{{ $user->mother_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-heart text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Marital Status</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($user->marital_status) ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-pray text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Religion</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($user->religion) ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Account Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-user-tag text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Account Role</p>
                                    <p class="font-medium text-gray-900">
                                        {{ ucfirst($user->roles->first()->name ?? 'No Role') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-plus text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Account Created</p>
                                    <p class="font-medium text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-check text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Last Updated</p>
                                    <p class="font-medium text-gray-900">{{ $user->updated_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-sign-in-alt text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Last Login</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-gray-400 w-6"></i>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Email Verified</p>
                                    <p class="font-medium text-gray-900">
                                        @if ($user->email_verified_at)
                                            <span class="text-green-600">Yes
                                                ({{ $user->email_verified_at->format('M d, Y') }})</span>
                                        @else
                                            <span class="text-red-600">Not Verified</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Information (if applicable) -->
                @if ($user->isDoctor())
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Doctor Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <i class="fas fa-id-badge text-gray-400 w-6"></i>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">BMDC Registration</p>
                                        <p class="font-medium text-gray-900">{{ $user->bmdc_registration ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-stethoscope text-gray-400 w-6"></i>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">Specialization</p>
                                        <p class="font-medium text-gray-900">{{ $user->specialization ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave text-gray-400 w-6"></i>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">Consultation Fee</p>
                                        <p class="font-medium text-gray-900">
                                            ৳{{ number_format($user->consultation_fee ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                @if ($user->qualifications)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Qualifications</p>
                                        <p class="font-medium text-gray-900">{{ $user->qualifications }}</p>
                                    </div>
                                @endif
                                @if ($user->experience)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Experience</p>
                                        <p class="font-medium text-gray-900">{{ $user->experience }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
