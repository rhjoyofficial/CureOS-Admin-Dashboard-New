@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('card-header', 'Confirm Password')

@section('content')
    <div class="mb-4 text-sm text-gray-600">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            </div>
            <div class="relative flex items-center">
                <input type="password" id="password_input" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your password">
                <button type="button" id="password_toggle"
                    class="absolute right-0 px-4 py-3 text-gray-500 hover:text-gray-700 transition-colors">
                    <i id="password_toggle_icon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Confirm Password
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const passwordInput = document.getElementById('password_input');
            const passwordToggle = document.getElementById('password_toggle');
            const passwordToggleIcon = document.getElementById('password_toggle_icon');

            // Toggle password visibility
            function togglePasswordVisibility() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'password') {
                    passwordToggleIcon.classList.remove('fa-eye-slash');
                    passwordToggleIcon.classList.add('fa-eye');
                } else {
                    passwordToggleIcon.classList.remove('fa-eye');
                    passwordToggleIcon.classList.add('fa-eye-slash');
                }
            }

            // Add event listener for password toggle
            passwordToggle.addEventListener('click', togglePasswordVisibility);
        });
    </script>
@endpush
