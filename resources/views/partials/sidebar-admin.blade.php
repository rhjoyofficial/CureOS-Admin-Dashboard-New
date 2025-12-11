<!-- Users -->
<div x-data="{ open: activeGroup === 'users' }">
    <button @click="open = !open; activeGroup = open ? 'users' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-users w-5 text-center"></i>
            <span>Users</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.users.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.users.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            All Users
        </a>
        <a href="{{ route('admin.users.create') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.users.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Add User
        </a>
    </div>
</div>

<!-- Patients -->
<div x-data="{ open: activeGroup === 'patients' }">
    <button @click="open = !open; activeGroup = open ? 'patients' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-user-injured w-5 text-center"></i>
            <span>Patients</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.patients.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.patients.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            All Patients
        </a>
        <a href="{{ route('admin.patients.create') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.patients.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Add Patient
        </a>
    </div>
</div>

<!-- Appointments -->
<div x-data="{ open: activeGroup === 'appointments' }">
    <button @click="open = !open; activeGroup = open ? 'appointments' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-calendar-check w-5 text-center"></i>
            <span>Appointments</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.appointments.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.appointments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            All Appointments
        </a>
        <a href="{{ route('admin.appointments.create') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.appointments.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Add Appointment
        </a>
    </div>
</div>

<!-- Medical -->
<div x-data="{ open: activeGroup === 'medical' }">
    <button @click="open = !open; activeGroup = open ? 'medical' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-stethoscope w-5 text-center"></i>
            <span>Medical</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.consultations.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.consultations.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Consultations
        </a>
        <a href="{{ route('admin.prescriptions.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.prescriptions.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Prescriptions
        </a>
        <a href="{{ route('admin.invoices.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Invoices
        </a>
    </div>
</div>

<!-- Reports -->
<div x-data="{ open: activeGroup === 'reports' }">
    <button @click="open = !open; activeGroup = open ? 'reports' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-chart-bar w-5 text-center"></i>
            <span>Reports</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('admin.reports.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Overview
        </a>
        <a href="{{ route('admin.reports.appointments') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.reports.appointments') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Appointments
        </a>
        <a href="{{ route('admin.reports.billing') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.reports.billing') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Billing
        </a>
    </div>
</div>

<!-- Settings -->
<a href="{{ route('admin.system-settings') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.system-settings') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-sliders-h w-5 text-center"></i>
    <span>System Settings</span>
</a>
