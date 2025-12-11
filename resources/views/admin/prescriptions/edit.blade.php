@extends('layouts.app')

@section('title', 'Edit Prescription')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Edit Prescription</h2>
                        <p class="text-sm text-gray-600">Update prescription details</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Patient: {{ $prescription->consultation->appointment->patient->name }}
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.prescriptions.update', $prescription) }}" method="POST" class="p-6 space-y-6"
                id="prescriptionForm">
                @csrf
                @method('PUT')

                <!-- Prescription Notes -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Prescription Notes</h3>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Doctor's Notes &
                            Advice</label>
                        <textarea name="notes" id="notes" rows="4"
                            placeholder="Enter any special instructions, advice, or notes for the patient..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $prescription->notes) }}</textarea>
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
                        @foreach ($prescription->items as $index => $item)
                            <div class="border border-gray-300 rounded-lg p-4 medicine-item">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-900">Medicine <span
                                            class="medicine-number">{{ $index + 1 }}</span></h4>
                                    <button type="button" class="remove-medicine text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name *</label>
                                        <input type="text" name="medicines[{{ $index }}][name]"
                                            value="{{ old('medicines.' . $index . '.name', $item->medicine_name) }}"
                                            required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosage *</label>
                                        <input type="text" name="medicines[{{ $index }}][dosage]"
                                            value="{{ old('medicines.' . $index . '.dosage', $item->dosage) }}"
                                            placeholder="e.g., 500mg" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                        <input type="text" name="medicines[{{ $index }}][duration]"
                                            value="{{ old('medicines.' . $index . '.duration', $item->duration) }}"
                                            placeholder="e.g., 7 days"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                                        <input type="text" name="medicines[{{ $index }}][instructions]"
                                            value="{{ old('medicines.' . $index . '.instructions', $item->instructions) }}"
                                            placeholder="e.g., After meal, Twice daily"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('medicines')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Patient Information (Read-only) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Patient Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-500">Patient</p>
                            <p class="font-medium text-gray-900">
                                {{ $prescription->consultation->appointment->patient->name }}</p>
                            <p class="text-sm text-gray-600">{{ $prescription->consultation->appointment->patient->phone }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium text-gray-900">Dr.
                                {{ $prescription->consultation->appointment->doctor->name }}</p>
                            <p class="text-sm text-gray-600">
                                {{ $prescription->consultation->appointment->doctor->specialization ?? 'General Physician' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Consultation Date</p>
                            <p class="font-medium text-gray-900">
                                {{ $prescription->consultation->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Medicines</p>
                            <p class="font-medium text-gray-900">{{ $prescription->items->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.prescriptions.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let medicineCount = {{ $prescription->items->count() }};

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
                medicineElement.querySelector('.medicine-number').textContent = medicineCount;

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

            // Add remove event listeners to existing medicine items
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.remove-medicine').forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.medicine-item').remove();
                        updateMedicineNumbers();
                    });
                });
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

