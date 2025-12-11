<!-- Patients -->
<a href="{{ route('staff.patients.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('staff.patients.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-user-injured w-5 text-center"></i>
    <span>Patients</span>
</a>

<!-- Appointments -->
<a href="{{ route('staff.appointments.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('staff.appointments.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-calendar-check w-5 text-center"></i>
    <span>Appointments</span>
</a>

<!-- Billing -->
<div x-data="{ open: activeGroup === 'billing' }">
    <button @click="open = !open; activeGroup = open ? 'billing' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-file-invoice-dollar w-5 text-center"></i>
            <span>Billing</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('staff.invoices.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('staff.invoices.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Invoices
        </a>
        <a href="{{ route('staff.reports.billing') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('staff.reports.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Billing Reports
        </a>
    </div>
</div>
