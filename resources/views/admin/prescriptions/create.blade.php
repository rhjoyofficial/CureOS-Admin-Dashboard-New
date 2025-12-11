@extends('layouts.app')

@section('title', 'Add New Prescription')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Add New Prescription</h2>
                <p class="text-sm text-gray-600">Create a new prescription for patient</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.prescriptions.store') }}" method="POST" class="p-6 space-y-6" id="prescriptionForm">
                @csrf

                <!-- Consultation Selection -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Select Consultation</h3>

                    @if ($availableConsultations->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <div>
                                    <p class="text-yellow-800 font-medium">No consultations available for prescription</p>
                                    <p class="text-yellow-700 text-sm mt-1">
                                        All consultations already have prescriptions. Please create a consultation first.
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

                <!-- Prescription Notes -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Prescription Notes</h3>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Doctor's Notes &
                            Advice</label>
                        <textarea name="notes" id="notes" rows="4"
                            placeholder="Enter any special instructions, advice, or notes for the patient..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Medicines -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Medicines</h3>
                        <button type="button" id="addMedicine"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus mr-1"></i> Add Medicine
                        </button>
                    </div>

                    <div id="medicinesContainer" class="space-y-4">
                        <!-- Medicine template will be added here by JavaScript -->
                    </div>

                    @error('medicines')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.prescriptions.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    @if (!$availableConsultations->isEmpty())
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Create Prescription
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let medicineCount = 0;

            // Medicine template
            const medicineTemplate = `
    <div class="border border-gray-300 rounded-lg p-4 medicine-item">
        <div class="flex items-center justify-between mb-3">
            <h4 class="font-medium text-gray-900">Medicine <span class="medicine-number">1</span></h4>
            <button type="button" class="remove-medicine text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name *</label>
                <input type="text" 
                       name="medicines[0][name]" 
                       required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dosage *</label>
                <input type="text" 
                       name="medicines[0][dosage]" 
                       placeholder="e.g., 500mg"
                       required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                <input type="text" 
                       name="medicines[0][duration]" 
                       placeholder="e.g., 7 days"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                        <input type="text" 
                       name="medicines[0][instructions]" 
                       placeholder="e.g., After meal, Twice daily"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>
    `;

            // Add medicine button handler
            document.getElementById('addMedicine').addEventListener('click', function() {
                const container = document.getElementById('medicinesContainer');
                const newMedicine = medicineTemplate.replace(/medicines\[0\]/g, `medicines[${medicineCount}]`);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newMedicine;
                const medicineElement = tempDiv.firstChild;

                // Update medicine number
                medicineCount++;
                medicineElement.querySelector('.medicine-number').textContent = medicineCount + 1;

                container.appendChild(medicineElement);

                // Add remove event listener
                medicineElement.querySelector('.remove-medicine').addEventListener('click', function() {
                    medicineElement.remove();
                    updateMedicineNumbers();
                });
            });

            // Update medicine numbers when items are removed
            function updateMedicineNumbers() {
                const items = document.querySelectorAll('.medicine-item');
                items.forEach((item, index) => {
                    item.querySelector('.medicine-number').textContent = index + 1;

                    // Update input names
                    const inputs = item.querySelectorAll('input');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            const newName = name.replace(/medicines\[\d+\]/, `medicines[${index}]`);
                            input.setAttribute('name', newName);
                        }
                    });
                });
                medicineCount = items.length;
            }

            // Add first medicine on page load
            document.addEventListener('DOMContentLoaded', function() {
                if (medicineCount === 0) {
                    document.getElementById('addMedicine').click();
                }
            });

            // Form validation
            document.getElementById('prescriptionForm').addEventListener('submit', function(e) {
                const medicines = document.querySelectorAll('.medicine-item');
                if (medicines.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one medicine to the prescription.');
                    return false;
                }
            });
        </script>
    @endpush
@endsection
