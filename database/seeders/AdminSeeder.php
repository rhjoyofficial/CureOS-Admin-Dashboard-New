<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@clinic.com',
            'phone' => '01700000001',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'nid' => '1234567890',
            'date_of_birth' => '1980-01-01',
            'blood_group' => 'O+',
            'district' => 'Dhaka',
            'upazila' => 'Gulshan',
        ]);

        $admin->assignRole('Admin');

        // Create additional admin
        User::create([
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
        ])->assignRole('Admin');
    }
}
