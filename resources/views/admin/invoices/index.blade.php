@extends('layouts.app')

@section('title', 'Invoices Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Invoices Management</h1>
                <p class="text-gray-600">Manage patient invoices and payments</p>
            </div>
            <a href="{{ route('admin.invoices.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Add New Invoice
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.invoices.index') }}"
                class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by patient, doctor, or phone..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial
                        </option>
                        <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="w-full md:w-40 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.invoices.index') }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $invoices->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            ৳{{ number_format($invoices->sum('total_amount'), 2) }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Paid Invoices</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $invoices->where('payment_status', 'paid')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Payments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $invoices->where('payment_status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Invoice #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50">
                                <!-- Invoice Number -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-blue-600">
                                        INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $invoice->id }}</div>
                                </td>

                                <!-- Patient -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                {{ $invoice->consultation->appointment->patient->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $invoice->consultation->appointment->patient->phone }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Doctor -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-md text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Dr.
                                                {{ $invoice->consultation->appointment->doctor->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $invoice->consultation->appointment->doctor->specialization ?? 'General' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Amount -->
                                <td class="px-6 py-4">
                                    <div class="text-lg font-bold text-gray-900">
                                        ৳{{ number_format($invoice->total_amount, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $invoice->items->count() }} items
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $invoice->payment_status == 'paid'
                                    ? 'bg-green-100 text-green-800'
                                    : ($invoice->payment_status == 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($invoice->payment_status == 'partial'
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($invoice->payment_status) }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $invoice->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $invoice->created_at->format('h:i A') }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.invoices.show', $invoice) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('admin.invoices.download', $invoice) }}"
                                            class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg"
                                            title="Download PDF">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        @if ($invoice->payment_status != 'paid')
                                            <form action="{{ route('admin.invoices.mark-paid', $invoice) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Mark this invoice as paid?')"
                                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg"
                                                    title="Mark as Paid">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this invoice?')"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <i class="fas fa-file-invoice-dollar text-gray-400 text-4xl mb-3"></i>
                                    <p class="text-gray-500">No invoices found</p>
                                    @if (request()->anyFilled(['search', 'payment_status', 'start_date', 'end_date']))
                                        <a href="{{ route('admin.invoices.index') }}"
                                            class="mt-2 inline-block text-blue-600 hover:text-blue-800">
                                            Clear filters
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($invoices->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $invoices->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

