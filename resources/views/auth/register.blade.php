@extends('layouts.guest')

@section('title', 'Register')

@section('card-header', 'Create a new account')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                autocomplete="name"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required autocomplete="tel"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            </div>
            <div class="relative flex items-center">
                <input type="password" id="password_input" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required autocomplete="new-password" placeholder="Enter your password">
                <button type="button" id="password_toggle"
                    class="absolute right-0 px-4 py-3 text-gray-500 hover:text-gray-700 transition-colors">
                    <i id="password_toggle_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <label for="password_confirmation_input" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
            </div>
            <div class="relative flex items-center">
                <input type="password" id="password_confirmation_input" name="password_confirmation"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required autocomplete="new-password" placeholder="Confirm your password">
                <button type="button" id="password_confirmation_toggle"
                    class="absolute right-0 px-4 py-3 text-gray-500 hover:text-gray-700 transition-colors">
                    <i id="password_confirmation_toggle_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Register
            </button>
        </div>
    </form>
@endsection

@section('card-footer')
    <div class="text-center">
        <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800">
                Sign in here
            </a>
        </p>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const passwordInput = document.getElementById('password_input');
            const passwordToggle = document.getElementById('password_toggle');
            const passwordToggleIcon = document.getElementById('password_toggle_icon');

            const passwordConfirmationInput = document.getElementById('password_confirmation_input');
            const passwordConfirmationToggle = document.getElementById('password_confirmation_toggle');
            const passwordConfirmationToggleIcon = document.getElementById('password_confirmation_toggle_icon');

            // Toggle password visibility
            function togglePasswordVisibility(input, icon) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            }

            // Add event listeners for both password fields
            passwordToggle.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput, passwordToggleIcon);
            });

            passwordConfirmationToggle.addEventListener('click', function() {
                togglePasswordVisibility(passwordConfirmationInput, passwordConfirmationToggleIcon);
            });
        });
    </script>
@endpush
