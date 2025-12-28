@extends('layouts.app')

@section('title', 'Add New Patient')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Add New Patient</h2>
                <p class="text-sm text-gray-600">Create a new patient record</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.patients.store') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number
                                *</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
                            <select name="gender" id="gender" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
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
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="Unknown" {{ old('blood_group') == 'Unknown' ? 'selected' : '' }}>Unknown
                                </option>
                            </select>
                            @error('blood_group')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Family Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Family Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Father Name -->
                        <div>
                            <label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">Father's
                                Name</label>
                            <input type="text" name="father_name" id="father_name" value="{{ old('father_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Mother Name -->
                        <div>
                            <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">Mother's
                                Name</label>
                            <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Husband/Wife Name -->
                        <div>
                            <label for="husband_wife_name" class="block text-sm font-medium text-gray-700 mb-1">Husband/Wife
                                Name</label>
                            <input type="text" name="husband_wife_name" id="husband_wife_name"
                                value="{{ old('husband_wife_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Occupation -->
                        <div>
                            <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                            <input type="text" name="occupation" id="occupation" value="{{ old('occupation') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">Marital
                                Status</label>
                            <select name="marital_status" id="marital_status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Marital Status</option>
                                <option value="Unmarried" {{ old('marital_status') == 'Unmarried' ? 'selected' : '' }}>
                                    Unmarried</option>
                                <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married
                                </option>
                                <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>
                                    Divorced</option>
                                <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed
                                </option>
                            </select>
                        </div>

                        <!-- Religion -->
                        <div>
                            <label for="religion" class="block text-sm font-medium text-gray-700 mb-1">Religion</label>
                            <select name="religion" id="religion"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Religion</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Hinduism" {{ old('religion') == 'Hinduism' ? 'selected' : '' }}>Hinduism
                                </option>
                                <option value="Christianity" {{ old('religion') == 'Christianity' ? 'selected' : '' }}>
                                    Christianity</option>
                                <option value="Buddhism" {{ old('religion') == 'Buddhism' ? 'selected' : '' }}>Buddhism
                                </option>
                                <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Address Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Division -->
                        <div>
                            <label for="division" class="block text-sm font-medium text-gray-700 mb-1">Division</label>
                            <input type="text" name="division" id="division" value="{{ old('division') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 mb-1">District</label>
                            <input type="text" name="district" id="district" value="{{ old('district') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Upazila -->
                        <div>
                            <label for="upazila" class="block text-sm font-medium text-gray-700 mb-1">Upazila</label>
                            <input type="text" name="upazila" id="upazila" value="{{ old('upazila') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Union -->
                        <div>
                            <label for="union" class="block text-sm font-medium text-gray-700 mb-1">Union</label>
                            <input type="text" name="union" id="union" value="{{ old('union') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Village -->
                        <div>
                            <label for="village" class="block text-sm font-medium text-gray-700 mb-1">Village</label>
                            <input type="text" name="village" id="village" value="{{ old('village') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Post Office -->
                        <div>
                            <label for="post_office" class="block text-sm font-medium text-gray-700 mb-1">Post
                                Office</label>
                            <input type="text" name="post_office" id="post_office" value="{{ old('post_office') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Post Code -->
                        <div>
                            <label for="post_code" class="block text-sm font-medium text-gray-700 mb-1">Post Code</label>
                            <input type="text" name="post_code" id="post_code" value="{{ old('post_code') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('post_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Address -->
                        <div class="md:col-span-2">
                            <label for="full_address" class="block text-sm font-medium text-gray-700 mb-1">Full
                                Address</label>
                            <textarea name="full_address" id="full_address" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('full_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Identification Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Identification Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nationality -->
                        <div>
                            <label for="nationality"
                                class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
                            <input type="text" name="nationality" id="nationality"
                                value="{{ old('nationality', 'Bangladeshi') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- NID -->
                        <div>
                            <label for="nid" class="block text-sm font-medium text-gray-700 mb-1">National ID
                                (NID)</label>
                            <input type="text" name="nid" id="nid" value="{{ old('nid') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nid')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Certificate -->
                        <div>
                            <label for="birth_certificate_no" class="block text-sm font-medium text-gray-700 mb-1">Birth
                                Certificate No</label>
                            <input type="text" name="birth_certificate_no" id="birth_certificate_no"
                                value="{{ old('birth_certificate_no') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Emergency Contact</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Emergency Contact Name -->
                        <div>
                            <label for="emergency_contact_name"
                                class="block text-sm font-medium text-gray-700 mb-1">Contact Person Name</label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                value="{{ old('emergency_contact_name') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Emergency Contact Phone -->
                        <div>
                            <label for="emergency_contact_phone"
                                class="block text-sm font-medium text-gray-700 mb-1">Contact Person Phone</label>
                            <input type="text" name="emergency_contact_phone" id="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Emergency Contact Relation -->
                        <div>
                            <label for="emergency_contact_relation"
                                class="block text-sm font-medium text-gray-700 mb-1">Relation</label>
                            <input type="text" name="emergency_contact_relation" id="emergency_contact_relation"
                                value="{{ old('emergency_contact_relation') }}"
                                placeholder="e.g., Father, Mother, Spouse"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Medical History -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Medical History</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Allergies -->
                        <div>
                            <label for="allergies" class="block text-sm font-medium text-gray-700 mb-1">Allergies</label>
                            <textarea name="allergies" id="allergies" rows="2" placeholder="List any known allergies..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('allergies') }}</textarea>
                        </div>

                        <!-- Current Medications -->
                        <div>
                            <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-1">Current
                                Medications</label>
                            <textarea name="current_medications" id="current_medications" rows="2"
                                placeholder="List current medications..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('current_medications') }}</textarea>
                        </div>

                        <!-- Past Medical History -->
                        <div>
                            <label for="past_medical_history" class="block text-sm font-medium text-gray-700 mb-1">Past
                                Medical History</label>
                            <textarea name="past_medical_history" id="past_medical_history" rows="2"
                                placeholder="Previous medical conditions, surgeries, etc..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('past_medical_history') }}</textarea>
                        </div>

                        <!-- Family Medical History -->
                        <div>
                            <label for="family_medical_history"
                                class="block text-sm font-medium text-gray-700 mb-1">Family Medical History</label>
                            <textarea name="family_medical_history" id="family_medical_history" rows="2"
                                placeholder="Family history of diseases..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('family_medical_history') }}</textarea>
                        </div>

                        <!-- Habits -->
                        <div>
                            <label for="habits" class="block text-sm font-medium text-gray-700 mb-1">Habits</label>
                            <textarea name="habits" id="habits" rows="2" placeholder="Smoking, alcohol consumption, exercise, etc..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('habits') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.patients.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Create Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
