@extends('layouts.app')

@section('title', 'Add New Invoice')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Add New Invoice</h2>
                <p class="text-sm text-gray-600">Create a new invoice for patient</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.invoices.store') }}" method="POST" class="p-6 space-y-6" id="invoiceForm">
                @csrf

                <!-- Consultation Selection -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Select Consultation</h3>

                    @if ($availableConsultations->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <div>
                                    <p class="text-yellow-800 font-medium">No consultations available for invoice</p>
                                    <p class="text-yellow-700 text-sm mt-1">
                                        All consultations already have invoices. Please create a consultation first.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('admin.consultations.create') }}"
                                class="mt-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Create Consultation
                            </a>
                        </div>
                    @else
                        <div>
                            <label for="consultation_id" class="block text-sm font-medium text-gray-700 mb-1">Consultation
                                *</label>
                            <select name="consultation_id" id="consultation_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Consultation</option>
                                @foreach ($availableConsultations as $consultation)
                                    <option value="{{ $consultation->id }}"
                                        {{ old('consultation_id') == $consultation->id ? 'selected' : '' }}>
                                        {{ $consultation->appointment->patient->name }} with Dr.
                                        {{ $consultation->appointment->doctor->name }}
                                        ({{ $consultation->created_at->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('consultation_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- Payment Status -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Payment Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status
                                *</label>
                            <select name="payment_status" id="payment_status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Status</option>
                                <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial
                                </option>
                                <option value="cancelled" {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                            <div class="text-2xl font-bold text-gray-900" id="totalAmountDisplay">
                                ৳0.00
                            </div>
                            <input type="hidden" id="totalAmount" name="total_amount" value="0">
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Services & Charges</h3>
                        <button type="button" id="addService"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus mr-1"></i> Add Service
                        </button>
                    </div>

                    <div id="servicesContainer" class="space-y-4">
                        <!-- Service template will be added here by JavaScript -->
                    </div>

                    @error('services')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.invoices.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    @if (!$availableConsultations->isEmpty())
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Invoice
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let serviceCount = 0;

            // Service template
            const serviceTemplate = `
    <div class="border border-gray-300 rounded-lg p-4 service-item">
        <div class="flex items-center justify-between mb-3">
            <h4 class="font-medium text-gray-900">Service <span class="service-number">1</span></h4>
            <button type="button" class="remove-service text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Description *</label>
                <input type="text" 
                       name="services[0][description]" 
                       required
                       placeholder="e.g., Consultation Fee, Medicine, Test, etc."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fee (৳) *</label>
                <input type="number" 
                       step="0.01"
                       min="0"
                       name="services[0][fee]" 
                       value="0"
                       required
                       class="service-fee w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>
    `;

            // Add service button handler
            document.getElementById('addService').addEventListener('click', function() {
                const container = document.getElementById('servicesContainer');
                const newService = serviceTemplate.replace(/services\[0\]/g, `services[${serviceCount}]`);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newService;
                const serviceElement = tempDiv.firstChild;

                // Update service number
                serviceCount++;
                serviceElement.querySelector('.service-number').textContent = serviceCount + 1;

                container.appendChild(serviceElement);

                // Add remove event listener
                serviceElement.querySelector('.remove-service').addEventListener('click', function() {
                    serviceElement.remove();
                    updateServiceNumbers();
                    calculateTotal();
                });

                // Add fee change listener
                serviceElement.querySelector('.service-fee').addEventListener('input', calculateTotal);
            });

            // Update service numbers when items are removed
            function updateServiceNumbers() {
                const items = document.querySelectorAll('.service-item');
                items.forEach((item, index) => {
                    item.querySelector('.service-number').textContent = index + 1;

                    // Update input names
                    const inputs = item.querySelectorAll('input');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            const newName = name.replace(/services\[\d+\]/, `services[${index}]`);
                            input.setAttribute('name', newName);
                        }
                    });
                });
                serviceCount = items.length;
            }

            // Calculate total amount
            function calculateTotal() {
                let total = 0;
                document.querySelectorAll('.service-fee').forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });

                document.getElementById('totalAmountDisplay').textContent = '৳' + total.toFixed(2);
                document.getElementById('totalAmount').value = total;
            }

            // Add first service on page load
            document.addEventListener('DOMContentLoaded', function() {
                if (serviceCount === 0) {
                    document.getElementById('addService').click();
                }
            });

            // Form validation
            document.getElementById('invoiceForm').addEventListener('submit', function(e) {
                const services = document.querySelectorAll('.service-item');
                if (services.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one service to the invoice.');
                    return false;
                }

                const total = parseFloat(document.getElementById('totalAmount').value);
                if (total <= 0) {
                    e.preventDefault();
                    alert('Total amount must be greater than 0.');
                    return false;
                }
            });
        </script>
    @endpush
@endsection
