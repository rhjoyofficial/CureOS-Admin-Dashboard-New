@extends('layouts.guest')

@section('title', 'Login')

@section('card-header', 'Sign in to your account')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Sign in
            </button>
        </div>
    </form>
@endsection

@section('card-footer')
    <div class="text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-800">
                    Register here
                </a>
            @endif
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
