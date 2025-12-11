<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CureOS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <img src="{{ asset('images/logos/logo.png') }}" alt="CureOS Logo"
                                class="w-full h-16 object-contain">
                        </a>

                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-primary text-white px-4 py-2 rounded-md hover:brand-blue">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="py-12">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl md:text-6xl">
                        Welcome to
                        <span class="text-primary">CureOS</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        A comprehensive clinic management system designed to streamline patient care, appointments,
                        prescriptions, and billing.
                    </p>
                    <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:brand-blue">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:brand-blue">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="py-12 bg-white">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 text-primary">
                            <i class="fas fa-user-injured text-3xl"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Patient Management</h3>
                        <p class="mt-2 text-gray-500">Efficiently manage patient records, history, and appointments.</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 text-primary">
                            <i class="fas fa-prescription-bottle-alt text-3xl"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Digital Prescriptions</h3>
                        <p class="mt-2 text-gray-500">Create, manage, and print prescriptions digitally.</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 text-primary">
                            <i class="fas fa-file-invoice-dollar text-3xl"></i>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Billing & Invoicing</h3>
                        <p class="mt-2 text-gray-500">Streamline billing process with automated invoicing.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
