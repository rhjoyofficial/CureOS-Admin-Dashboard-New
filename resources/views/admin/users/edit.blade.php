@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Edit User: {{ $user->name }}</h2>
                <p class="text-sm text-gray-600">Update user information</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address
                                *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NID -->
                        <div>
                            <label for="nid" class="block text-sm font-medium text-gray-700 mb-1">National ID
                                (NID)</label>
                            <input type="text" name="nid" id="nid" value="{{ old('nid', $user->nid) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nid')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood
                                Group</label>
                            <select name="blood_group" id="blood_group"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Blood Group</option>
                                <option value="A+"
                                    {{ old('blood_group', $user->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-"
                                    {{ old('blood_group', $user->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+"
                                    {{ old('blood_group', $user->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-"
                                    {{ old('blood_group', $user->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+"
                                    {{ old('blood_group', $user->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-"
                                    {{ old('blood_group', $user->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+"
                                    {{ old('blood_group', $user->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-"
                                    {{ old('blood_group', $user->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_group')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 mb-1">District</label>
                            <input type="text" name="district" id="district"
                                value="{{ old('district', $user->district) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('district')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upazila -->
                        <div>
                            <label for="upazila" class="block text-sm font-medium text-gray-700 mb-1">Upazila</label>
                            <input type="text" name="upazila" id="upazila"
                                value="{{ old('upazila', $user->upazila) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('upazila')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Account Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                            <select name="role" id="role" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="deactivated"
                                    {{ old('status', $user->status) == 'deactivated' ? 'selected' : '' }}>Deactivated
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (Leave
                                blank to keep current)</label>
                            <input type="password" name="password" id="password"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Doctor Specific Fields -->
                <div id="doctor-fields" class="space-y-4 {{ $user->isDoctor() ? '' : 'hidden' }}">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Doctor Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- BMDC Registration -->
                        <div>
                            <label for="bmdc_registration" class="block text-sm font-medium text-gray-700 mb-1">BMDC
                                Registration</label>
                            <input type="text" name="bmdc_registration" id="bmdc_registration"
                                value="{{ old('bmdc_registration', $user->bmdc_registration) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('bmdc_registration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label for="specialization"
                                class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                            <input type="text" name="specialization" id="specialization"
                                value="{{ old('specialization', $user->specialization) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('specialization')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Consultation Fee -->
                        <div>
                            <label for="consultation_fee"
                                class="block text-sm font-medium text-gray-700 mb-1">Consultation Fee (৳)</label>
                            <input type="number" step="0.01" name="consultation_fee" id="consultation_fee"
                                value="{{ old('consultation_fee', $user->consultation_fee) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('consultation_fee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Qualifications -->
                        <div class="md:col-span-2">
                            <label for="qualifications"
                                class="block text-sm font-medium text-gray-700 mb-1">Qualifications</label>
                            <textarea name="qualifications" id="qualifications" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('qualifications', $user->qualifications) }}</textarea>
                            @error('qualifications')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience -->
                        <div class="md:col-span-2">
                            <label for="experience"
                                class="block text-sm font-medium text-gray-700 mb-1">Experience</label>
                            <textarea name="experience" id="experience" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('experience', $user->experience) }}</textarea>
                            @error('experience')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Additional Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Father Name -->
                        <div>
                            <label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">Father's
                                Name</label>
                            <input type="text" name="father_name" id="father_name"
                                value="{{ old('father_name', $user->father_name) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Mother Name -->
                        <div>
                            <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">Mother's
                                Name</label>
                            <input type="text" name="mother_name" id="mother_name"
                                value="{{ old('mother_name', $user->mother_name) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">Marital
                                Status</label>
                            <select name="marital_status" id="marital_status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Marital Status</option>
                                <option value="married"
                                    {{ old('marital_status', $user->marital_status) == 'married' ? 'selected' : '' }}>
                                    Married</option>
                                <option value="unmarried"
                                    {{ old('marital_status', $user->marital_status) == 'unmarried' ? 'selected' : '' }}>
                                    Unmarried</option>
                                <option value="divorced"
                                    {{ old('marital_status', $user->marital_status) == 'divorced' ? 'selected' : '' }}>
                                    Divorced</option>
                                <option value="widowed"
                                    {{ old('marital_status', $user->marital_status) == 'widowed' ? 'selected' : '' }}>
                                    Widowed</option>
                            </select>
                        </div>

                        <!-- Religion -->
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                            <select name="religion" id="religion"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Religion</option>
                                <option value="islam"
                                    {{ old('religion', $user->religion) == 'islam' ? 'selected' : '' }}>Islam</option>
                                <option value="hinduism"
                                    {{ old('religion', $user->religion) == 'hinduism' ? 'selected' : '' }}>Hinduism
                                </option>
                                <option value="christianity"
                                    {{ old('religion', $user->religion) == 'christianity' ? 'selected' : '' }}>Christianity
                                </option>
                                <option value="buddhism"
                                    {{ old('religion', $user->religion) == 'buddhism' ? 'selected' : '' }}>Buddhism
                                </option>
                                <option value="other"
                                    {{ old('religion', $user->religion) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1">Emergency
                                Contact</label>
                            <input type="text" name="emergency_contact" id="emergency_contact"
                                value="{{ old('emergency_contact', $user->emergency_contact) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Village -->
                        <div>
                            <label for="village" class="block text-sm font-medium text-gray-700 mb-1">Village</label>
                            <input type="text" name="village" id="village"
                                value="{{ old('village', $user->village) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Post Office -->
                        <div>
                            <label for="post_office" class="block text-sm font-medium text-gray-700 mb-1">Post
                                Office</label>
                            <input type="text" name="post_office" id="post_office"
                                value="{{ old('post_office', $user->post_office) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Post Code -->
                        <div>
                            <label for="post_code" class="block text-sm font-medium text-gray-700 mb-1">Post Code</label>
                            <input type="text" name="post_code" id="post_code"
                                value="{{ old('post_code', $user->post_code) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Show/hide doctor fields based on role selection
            document.getElementById('role').addEventListener('change', function() {
                const doctorFields = document.getElementById('doctor-fields');
                if (this.value === 'Doctor') {
                    doctorFields.classList.remove('hidden');
                } else {
                    doctorFields.classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection
