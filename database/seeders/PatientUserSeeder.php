<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientUserSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Patient One',
                'email' => 'patient1@example.com',
                'phone' => '01730000001',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '3000000001',
                'date_of_birth' => '1985-01-15',
                'blood_group' => 'A+',
                'district' => 'Dhaka',
                'upazila' => 'Dhanmondi',
                'marital_status' => 'married',
                'religion' => 'islam',
            ],
            [
                'name' => 'Patient Two',
                'email' => 'patient2@example.com',
                'phone' => '01730000002',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '3000000002',
                'date_of_birth' => '1990-05-20',
                'blood_group' => 'B+',
                'district' => 'Dhaka',
                'upazila' => 'Mirpur',
                'marital_status' => 'unmarried',
                'religion' => 'islam',
            ],
        ];

        foreach ($patients as $patient) {
            User::create($patient)->assignRole('Patient');
        }
    }
}