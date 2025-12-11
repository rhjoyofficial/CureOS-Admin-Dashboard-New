<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
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
            User::create($staffMember)->assignRole('Staff');
        }
    }
}
