@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('card-header', 'Forgot your password?')

@section('content')
    <div class="mb-4 text-sm text-gray-600">
        No problem. Just let us know your email address and we will email you a password reset link that will allow you to
        choose a new one.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="submit"
                class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Email Password Reset Link
            </button>

            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Back to login
            </a>
        </div>
    </form>
@endsection
