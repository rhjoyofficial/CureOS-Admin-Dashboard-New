<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-gray-200 flex flex-col no-scrollbar" x-data="{ activeGroup: '' }">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-heartbeat text-white text-lg"></i>
            </div>
            <span class="text-xl font-bold text-gray-900">Cure<span class="text-blue-600">OS</span></span>
        </a>
    </div>

    <!-- User Profile -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-blue-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto no-scrollbar">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-tachometer-alt w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        @role('Admin')
            @include('partials.sidebar-admin')
        @endrole

        @role('Doctor')
            @include('partials.sidebar-doctor')
        @endrole

        @role('Staff')
            @include('partials.sidebar-staff')
        @endrole

        @role('Patient')
            @include('partials.sidebar-patient')
        @endrole

        <!-- Settings -->
        <a href="{{ route('profile.edit') }}"
            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-cog w-5 text-center"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center space-x-3 w-full px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
