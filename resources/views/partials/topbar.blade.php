<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
    <!-- Left: Search & Menu Toggle -->
    <div class="flex items-center space-x-4">
        <!-- Mobile Menu Toggle -->
        <button id="sidebarToggle" class="md:hidden text-gray-500 hover:text-gray-700">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Search -->
        <div class="hidden md:block relative">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input type="search" placeholder="Search..."
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
        </div>
    </div>

    <!-- Right: Notifications & User Menu -->
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="relative">
            <button id="notificationButton" class="relative p-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- Notification Dropdown -->
            <div id="notificationDropdown"
                class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900">Notifications</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <!-- Notification items would go here -->
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                        <p class="text-sm text-gray-900">New appointment scheduled</p>
                        <p class="text-xs text-gray-500">2 minutes ago</p>
                    </div>
                </div>
                <div class="p-2 border-t border-gray-200">
                    <a href="#" class="block text-center text-sm text-blue-600 hover:text-blue-800 py-2">
                        View all notifications
                    </a>
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div class="relative">
            <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <span class="hidden md:inline text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down text-gray-400"></i>
            </button>

            <!-- User Dropdown -->
            <div id="userDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                <div class="py-2">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-3"></i>
                        Profile
                    </a>
                    <a href="{{ route('settings.index') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                    <div class="border-t border-gray-200"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Toggle notifications dropdown
    document.getElementById('notificationButton').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('notificationDropdown').classList.toggle('hidden');
    });

    // Toggle user dropdown
    document.getElementById('userMenuButton').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('userDropdown').classList.toggle('hidden');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.getElementById('notificationDropdown').classList.add('hidden');
        document.getElementById('userDropdown').classList.add('hidden');
    });

    // Toggle mobile sidebar
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('aside').classList.toggle('hidden');
        document.querySelector('aside').classList.toggle('md:flex');
    });
</script>
