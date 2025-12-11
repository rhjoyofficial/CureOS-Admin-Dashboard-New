<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $consultations = \App\Models\Consultation::all();
        $medicines = [
            ['name' => 'Paracetamol', 'dosage' => '500mg', 'duration' => '5 days'],
            ['name' => 'Amoxicillin', 'dosage' => '250mg', 'duration' => '7 days'],
            ['name' => 'Ibuprofen', 'dosage' => '400mg', 'duration' => '3 days'],
            ['name' => 'Cetirizine', 'dosage' => '10mg', 'duration' => '7 days'],
            ['name' => 'Omeprazole', 'dosage' => '20mg', 'duration' => '14 days'],
        ];

        foreach ($consultations as $consultation) {
            $prescription = Prescription::create([
                'consultation_id' => $consultation->id,
                'notes' => 'Take medications as prescribed. Avoid alcohol. Follow up if symptoms persist.',
            ]);

            // Add 2-3 medicine items per prescription
            $numItems = rand(2, 3);
            $selectedMedicines = array_rand($medicines, $numItems);
            $selectedMedicines = is_array($selectedMedicines) ? $selectedMedicines : [$selectedMedicines];

            foreach ($selectedMedicines as $index) {
                $medicine = $medicines[$index];
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_name' => $medicine['name'],
                    'dosage' => $medicine['dosage'],
                    'duration' => $medicine['duration'],
                    'instructions' => 'Take after meals. Do not exceed recommended dosage.',
                ]);
            }
        }
    }
}
