<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        $appointments = \App\Models\Appointment::where('status', 'completed')->get();

        foreach ($appointments as $appointment) {
            Consultation::create([
                'appointment_id' => $appointment->id,
                'visit_notes' => "Patient presented with symptoms. Conducted examination and provided advice. Follow-up recommended in " . rand(1, 4) . " weeks.",
            ]);
        }
    }
}
