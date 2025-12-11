<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin users first
        $this->createAdminUsers();

        // Create Doctor users
        $this->createDoctorUsers();

        // Create Staff users
        $this->createStaffUsers();

        // Create Patient users
        $this->createPatientUsers();
    }

    private function createAdminUsers(): void
    {
        $admins = [
            [
                'name' => 'Rakibul Hasan Joy',
                'email' => 'admin@example.com',
                'phone' => '01700000001',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '1234567890',
                'date_of_birth' => '1980-01-01',
                'blood_group' => 'O+',
                'district' => 'Dhaka',
                'upazila' => 'Gulshan',
            ],
            [
                'name' => 'Clinic Manager',
                'email' => 'manager@clinic.com',
                'phone' => '01700000002',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '1234567891',
                'date_of_birth' => '1985-05-15',
                'blood_group' => 'A+',
                'district' => 'Dhaka',
                'upazila' => 'Banani',
            ],
        ];

        foreach ($admins as $admin) {
            $user = User::firstOrCreate(
                ['email' => $admin['email']],
                $admin
            );
            $user->assignRole('Admin');
        }
    }

    private function createDoctorUsers(): void
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
            $user = User::firstOrCreate(
                ['email' => $doctor['email']],
                $doctor
            );
            $user->assignRole('Doctor');
        }
    }

    private function createStaffUsers(): void
    {
        $staff = [
            [
                'name' => 'Receptionist One',
                'email' => 'reception@clinic.com',
                'phone' => '01720000001',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '2000000001',
                'date_of_birth' => '1990-04-10',
                'blood_group' => 'O+',
                'district' => 'Dhaka',
                'upazila' => 'Mohammadpur',
            ],
            [
                'name' => 'Account Manager',
                'email' => 'accounts@clinic.com',
                'phone' => '01720000002',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'nid' => '2000000002',
                'date_of_birth' => '1988-07-22',
                'blood_group' => 'B+',
                'district' => 'Dhaka',
                'upazila' => 'Farmgate',
            ],
        ];

        foreach ($staff as $staffMember) {
            $user = User::firstOrCreate(
                ['email' => $staffMember['email']],
                $staffMember
            );
            $user->assignRole('Staff');
        }
    }

    private function createPatientUsers(): void
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
            $user = User::firstOrCreate(
                ['email' => $patient['email']],
                $patient
            );
            $user->assignRole('Patient');
        }
    }
}
