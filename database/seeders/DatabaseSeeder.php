<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,   // First: Create ONLY roles and permissions
            UserSeeder::class,             // Second: Create users and assign roles
            PatientSeeder::class,          // Third: Create patients (requires users)
            AppointmentSeeder::class,      // Fourth: Create appointments (requires patients & doctors)
            ConsultationSeeder::class,     // Fifth: Create consultations (requires appointments)
            PrescriptionSeeder::class,     // Sixth: Create prescriptions (requires consultations)
            InvoiceSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Total seeded: Roles & Permissions, Users (with roles), Patients, Appointments, Consultations, Prescriptions, Invoices');
    }
}
