<!-- My Appointments -->
<a href="{{ route('patient.appointments.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.appointments.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-calendar-check w-5 text-center"></i>
    <span>Appointments</span>
</a>

<!-- My Prescriptions -->
<a href="{{ route('patient.prescriptions.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.prescriptions.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-prescription-bottle-alt w-5 text-center"></i>
    <span>Prescriptions</span>
</a>

<!-- My Invoices -->
<a href="{{ route('patient.invoices.index') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.invoices.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-file-invoice-dollar w-5 text-center"></i>
    <span>Invoices</span>
</a>

<!-- My Profile -->
<a href="{{ route('patient.profile') }}"
    class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('patient.profile') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
    <i class="fas fa-user-circle w-5 text-center"></i>
    <span>My Profile</span>
</a>
