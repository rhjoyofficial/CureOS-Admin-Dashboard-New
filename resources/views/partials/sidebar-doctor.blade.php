<!-- Patients -->
<div x-data="{ open: activeGroup === 'patients' }">
    <button @click="open = !open; activeGroup = open ? 'patients' : null"
        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <i class="fas fa-user-injured w-5 text-center"></i>
            <span>My Patients</span>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
            :class="{ 'transform rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('doctor.patients.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('doctor.patients.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            All Patients
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
        <a href="{{ route('doctor.appointments.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('doctor.appointments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            My Schedule
        </a>
        <a href="{{ route('doctor.appointments.create') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('doctor.appointments.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
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
        <a href="{{ route('doctor.consultations.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('doctor.consultations.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Consultations
        </a>
        <a href="{{ route('doctor.prescriptions.index') }}"
            class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('doctor.prescriptions.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            Prescriptions
        </a>
    </div>
</div>

<!-- Reports -->
<a href="{{ route('doctor.reports.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('doctor.reports.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-chart-bar w-5 text-center"></i>
    <span>Reports</span>
</a>
