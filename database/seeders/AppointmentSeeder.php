<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = User::role('Doctor')->get();

        $appointments = [];
        $now = now();

        foreach ($patients as $index => $patient) {
            foreach ($doctors as $doctorIndex => $doctor) {
                $appointmentTime = $now->copy()->addDays($index + $doctorIndex)->setHour(9)->setMinute(0);

                $appointments[] = [
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $appointmentTime,
                    'status' => $index === 0 ? 'completed' : 'scheduled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Appointment::insert($appointments);
    }
}
