<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-scrollbar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Cure OS') }}@hasSection('title')
            - @yield('title')
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cambay:ital,wght@0,400;0,700;1,400;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Quantico:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Push Styles & Scripts -->
    @stack('head-scripts')
    @stack('styles')
</head>

<body class="font-inter antialiased">
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">

        <!-- Svg Background -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            {{-- here svg will work as background, will put manually --}}
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:svgjs="http://svgjs.com/svgjs" width="100%" height="100%" preserveAspectRatio="none"
                viewBox="0 0 1920 1028">
                <g mask="url(&quot;#SvgjsMask1166&quot;)" fill="none">
                    <use xlink:href="#SvgjsSymbol1173" x="0" y="0"></use>
                    <use xlink:href="#SvgjsSymbol1173" x="0" y="720"></use>
                    <use xlink:href="#SvgjsSymbol1173" x="720" y="0"></use>
                    <use xlink:href="#SvgjsSymbol1173" x="720" y="720"></use>
                    <use xlink:href="#SvgjsSymbol1173" x="1440" y="0"></use>
                    <use xlink:href="#SvgjsSymbol1173" x="1440" y="720"></use>
                </g>
                <defs>
                    <mask id="SvgjsMask1166">
                        <rect width="1920" height="1028" fill="#ffffff"></rect>
                    </mask>
                    <path d="M-1 0 a1 1 0 1 0 2 0 a1 1 0 1 0 -2 0z" id="SvgjsPath1171"></path>
                    <path d="M-3 0 a3 3 0 1 0 6 0 a3 3 0 1 0 -6 0z" id="SvgjsPath1170"></path>
                    <path d="M-5 0 a5 5 0 1 0 10 0 a5 5 0 1 0 -10 0z" id="SvgjsPath1169"></path>
                    <path d="M2 -2 L-2 2z" id="SvgjsPath1168"></path>
                    <path d="M6 -6 L-6 6z" id="SvgjsPath1167"></path>
                    <path d="M30 -30 L-30 30z" id="SvgjsPath1172"></path>
                </defs>
                <symbol id="SvgjsSymbol1173">
                    <use xlink:href="#SvgjsPath1167" x="30" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="30" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="30" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="30" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="30" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="30" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="30" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="30" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="30" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="30" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="30" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="30" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="90" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="90" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="90" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="90" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="90" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="90" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="90" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="90" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="90" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="90" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="90" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="90" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="150" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="150" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="150" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="150" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="150" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="150" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="150" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="150" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="150" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="150" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="150" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="150" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="210" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="210" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="210" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="210" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="210" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="270" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="270" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="270" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="270" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="270" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="270" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="270" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="270" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="270" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="270" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1172" x="270" y="630" class="stroke-primary/20" stroke-width="3">
                    </use>
                    <use xlink:href="#SvgjsPath1171" x="270" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="330" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="330" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="330" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="330" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="330" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="330" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="330" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="330" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="330" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="330" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="330" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="330" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="390" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="390" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="390" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="390" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="390" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="390" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="390" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="390" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="390" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="390" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="390" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="390" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="450" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="450" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="450" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="450" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="450" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="450" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="450" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="450" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="450" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="450" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1172" x="450" y="630" class="stroke-primary/20" stroke-width="3">
                    </use>
                    <use xlink:href="#SvgjsPath1168" x="450" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="510" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="510" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1172" x="510" y="150" class="stroke-primary/20" stroke-width="3">
                    </use>
                    <use xlink:href="#SvgjsPath1171" x="510" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="510" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="510" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="510" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="510" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="510" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="510" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="570" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="570" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="570" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="570" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="570" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="570" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="570" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="570" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="570" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="570" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="570" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="570" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="630" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="630" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="630" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="630" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="630" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="630" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="630" y="690" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="690" y="30" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="90" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1170" x="690" y="150" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="210" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="270" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="330" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="390" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1167" x="690" y="450" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="690" y="510" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1169" x="690" y="570" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1168" x="690" y="630" class="stroke-primary/20"></use>
                    <use xlink:href="#SvgjsPath1171" x="690" y="690" class="stroke-primary/20"></use>
                </symbol>
            </svg>
        </div>


        <!-- Logo -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 z-10">
            <a href="{{ url('/') }}" class="flex justify-center">
                <img src="{{ asset('images/logos/logo.png') }}" alt="Cure OS Logo" class="h-12 md:h-20 w-auto">
            </a>
        </div>

        <!-- Card Container -->
        <div class="w-full sm:max-w-md px-6 py-4 z-10">
            <!-- Authentication Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Card Header -->
                @hasSection('card-header')
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 text-center">
                            @yield('card-header')
                        </h2>
                    </div>
                @endif

                <!-- Card Content -->
                <div class="px-6 py-8">
                    <!-- Session Status for Breeze -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors for Breeze -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>

                <!-- Card Footer (optional) -->
                @hasSection('card-footer')
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="text-center text-sm text-gray-600">
                            @yield('card-footer')
                        </div>
                    </div>
                @endif
            </div>

            <!-- Additional Links (like back to home, etc.) -->
            @hasSection('additional-links')
                <div class="mt-6 text-center">
                    @yield('additional-links')
                </div>
            @endif
        </div>

        <!-- Back to Home -->
        <div class="w-full sm:max-w-md px-6 py-4 text-center z-10">
            <a href="{{ url('/') }}"
                class="text-sm text-gray-600 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
