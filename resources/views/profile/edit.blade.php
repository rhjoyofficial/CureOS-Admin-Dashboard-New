@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Profile Settings</h2>
                <p class="text-gray-600">Update your personal information and password</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Profile Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Update Profile Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name *
                                        </label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $user->name) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address *
                                        </label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>

                                <!-- Form Actions -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>

                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <!-- Current Password -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                            Current Password *
                                        </label>
                                        <input type="password" name="current_password" id="current_password" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                            New Password *
                                        </label>
                                        <input type="password" name="password" id="password" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm New Password *
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
