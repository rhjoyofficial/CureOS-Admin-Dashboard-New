<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',
            'toggle user status',

            // Patients
            'view patients',
            'create patients',
            'edit patients',
            'delete patients',
            'export patients',

            // Appointments
            'view appointments',
            'create appointments',
            'edit appointments',
            'delete appointments',
            'cancel appointments',
            'complete appointments',

            // Consultations
            'view consultations',
            'create consultations',
            'edit consultations',
            'delete consultations',

            // Prescriptions
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
            'download prescriptions',

            // Invoices
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            'download invoices',
            'mark invoices paid',

            // Reports
            'view reports',
            'export reports',

            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $doctorRole = Role::firstOrCreate(['name' => 'Doctor', 'guard_name' => 'web']);
        $doctorPermissions = [
            'view dashboard',
            'view patients',
            'create patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'cancel appointments',
            'complete appointments',
            'view consultations',
            'create consultations',
            'edit consultations',
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'download prescriptions',
            'view reports',
        ];
        $doctorRole->givePermissionTo($doctorPermissions);

        $staffRole = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);
        $staffPermissions = [
            'view dashboard',
            'view patients',
            'create patients',
            'edit patients',
            'view appointments',
            'create appointments',
            'edit appointments',
            'cancel appointments',
            'view invoices',
            'create invoices',
            'mark invoices paid',
            'download invoices',
            'view reports',
        ];
        $staffRole->givePermissionTo($staffPermissions);

        $patientRole = Role::firstOrCreate(['name' => 'Patient', 'guard_name' => 'web']);
        $patientPermissions = [
            'view dashboard',
            'view appointments',
            'create appointments',
            'cancel appointments',
            'view prescriptions',
            'download prescriptions',
            'view invoices',
            'download invoices',
        ];
        $patientRole->givePermissionTo($patientPermissions);
    }
}
