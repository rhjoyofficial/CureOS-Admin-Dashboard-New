<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Ahmed Khan',
                'email' => 'dr.ahmed@clinic.com',
                'phone' => '01710000001',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '1000000001',
                'bmdc_registration' => 'BMDC-12345',
                'specialization' => 'Cardiology',
                'consultation_fee' => 1000.00,
                'qualifications' => 'MBBS, FCPS, MD',
                'experience' => '15 years in cardiology',
                'date_of_birth' => '1975-03-15',
                'blood_group' => 'B+',
                'district' => 'Dhaka',
                'upazila' => 'Dhanmondi',
            ],
            [
                'name' => 'Dr. Fatima Begum',
                'email' => 'dr.fatima@clinic.com',
                'phone' => '01710000002',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '1000000002',
                'bmdc_registration' => 'BMDC-12346',
                'specialization' => 'Pediatrics',
                'consultation_fee' => 800.00,
                'qualifications' => 'MBBS, DCH, MD',
                'experience' => '12 years in pediatrics',
                'date_of_birth' => '1980-08-20',
                'blood_group' => 'A+',
                'district' => 'Dhaka',
                'upazila' => 'Mirpur',
            ],
            [
                'name' => 'Dr. Rahman Ali',
                'email' => 'dr.rahman@clinic.com',
                'phone' => '01710000003',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '1000000003',
                'bmdc_registration' => 'BMDC-12347',
                'specialization' => 'Orthopedics',
                'consultation_fee' => 1200.00,
                'qualifications' => 'MBBS, MS, FRCS',
                'experience' => '18 years in orthopedics',
                'date_of_birth' => '1972-11-30',
                'blood_group' => 'AB+',
                'district' => 'Dhaka',
                'upazila' => 'Uttara',
            ],
        ];

        foreach ($doctors as $doctor) {
            User::create($doctor)->assignRole('Doctor');
        }
    }
}
