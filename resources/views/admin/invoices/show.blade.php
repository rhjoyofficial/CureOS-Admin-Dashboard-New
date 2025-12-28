@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Invoice Details</h1>
                        <p class="text-gray-600">Invoice #: INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <span
                            class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $invoice->payment_status == 'paid'
                            ? 'bg-green-100 text-green-800'
                            : ($invoice->payment_status == 'pending'
                                ? 'bg-yellow-100 text-yellow-800'
                                : ($invoice->payment_status == 'partial'
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($invoice->payment_status) }}
                        </span>
                        <a href="{{ route('admin.invoices.edit', $invoice) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('admin.invoices.download', $invoice) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-download mr-1"></i> Download PDF
                        </a>
                        <a href="{{ route('admin.invoices.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="p-6 space-y-8">
                <!-- Patient & Doctor Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Patient Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Patient Information</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">
                                    {{ $invoice->consultation->appointment->patient->name }}</p>
                                <p class="text-sm text-gray-600">{{ $invoice->consultation->appointment->patient->phone }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $invoice->consultation->appointment->patient->email ?? 'No email' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->patient->gender }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Age</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->patient->age ?? 'N/A' }} years</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Blood Group</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->patient->blood_group ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Patient ID</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->patient->patient_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Doctor Information</h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">Dr.
                                    {{ $invoice->consultation->appointment->doctor->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $invoice->consultation->appointment->doctor->specialization ?? 'General Physician' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $invoice->consultation->appointment->doctor->bmdc_registration ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-sm text-gray-500">Consultation Fee</p>
                                <p class="font-medium text-gray-900">
                                    <span
                                        class="font-bengali">৳</span>{{ number_format($invoice->consultation->appointment->doctor->consultation_fee ?? 0, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->doctor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">Qualifications</p>
                                <p class="font-medium text-gray-900">
                                    {{ $invoice->consultation->appointment->doctor->qualifications ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Summary -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Invoice Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Invoice Number</p>
                            <p class="font-bold text-gray-900 text-lg">
                                INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="font-bold text-gray-900 text-lg"><span
                                    class="font-bengali">৳</span>{{ number_format($invoice->total_amount, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Invoice Date</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $invoice->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <p class="font-bold text-gray-900 text-lg">{{ ucfirst($invoice->payment_status) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Services List -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Services & Charges
                        ({{ $invoice->items->count() }})</h3>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SL</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service Description</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fee (৳)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($invoice->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->service_description }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            <span class="font-bengali">৳</span>{{ number_format($item->fee, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Total Row -->
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 text-right font-medium text-gray-900" colspan="2">
                                        Total Amount:
                                    </td>
                                    <td class="px-6 py-4 text-xl font-bold text-gray-900">
                                        <span class="font-bengali">৳</span>{{ number_format($invoice->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Consultation Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Consultation Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Consultation Date</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $invoice->consultation->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Consultation Time</p>
                            <p class="font-bold text-gray-900 text-lg">
                                {{ $invoice->consultation->created_at->format('h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <a href="{{ route('admin.consultations.show', $invoice->consultation) }}"
                                class="block text-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                View Consultation
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Actions -->
                <!-- Payment Actions -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Actions</h3>
                            <p class="text-sm text-gray-600">
                                @if ($invoice->payment_status == 'paid')
                                    <span class="inline-flex items-center text-green-600">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        This invoice has been fully paid.
                                    </span>
                                @elseif($invoice->payment_status == 'partial')
                                    <span class="inline-flex items-center text-blue-600">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Partial payment received.
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-yellow-600">
                                        <i class="fas fa-clock mr-2"></i>
                                        Payment is pending.
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @if ($invoice->payment_status != 'paid')
                                <a href="{{ route('admin.invoices.recordPayment', $invoice) }}"
                                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 flex items-center">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Record Payment
                                </a>
                            @endif

                            @if ($invoice->payment_status == 'paid')
                                <button onclick="printInvoice()"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 flex items-center">
                                    <i class="fas fa-print mr-2"></i>
                                    Print Invoice
                                </button>
                            @endif

                            <button onclick="shareInvoice()"
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 flex items-center">
                                <i class="fas fa-share-alt mr-2"></i>
                                Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Invoice Notes -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h3>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-sm text-gray-600 italic">
                                @if ($invoice->consultation->visit_notes)
                                    {{ Str::limit($invoice->consultation->visit_notes, 200) }}
                                @else
                                    No additional notes available for this consultation.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Invoice History -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice History</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <div class="flex-shrink-0 w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium text-gray-900">Invoice Created</p>
                                    <p class="text-gray-500">{{ $invoice->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @if ($invoice->deleted_at)
                                <div class="flex items-center text-sm">
                                    <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                    <div>
                                        <p class="font-medium text-gray-900">Invoice Deleted</p>
                                        <p class="text-gray-500">{{ $invoice->deleted_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($invoice->updated_at != $invoice->created_at)
                                <div class="flex items-center text-sm">
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <div>
                                        <p class="font-medium text-gray-900">Last Updated</p>
                                        <p class="text-gray-500">{{ $invoice->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function printInvoice() {
                window.print();
            }

            function shareInvoice() {
                // For demo purposes - in a real app, implement actual sharing
                alert('Share functionality would open native sharing dialog here');
            }
        </script>
    @endpush
@endsection
