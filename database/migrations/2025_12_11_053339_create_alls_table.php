<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->string('phone')->nullable()->unique();
        //     $table->string('password');
        //     $table->enum('status', ['active', 'deactivated'])->default('active');
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->rememberToken();
        //     $table->softDeletes();
        //     $table->timestamps();
        // });

        // Schema::create('roles', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique(); // admin, doctor, staff, patient
        //     $table->string('display_name');
        //     $table->text('description')->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('role_user', function (Blueprint $table) {
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('role_id')->constrained()->onDelete('cascade');
        //     $table->primary(['user_id', 'role_id']);
        //     $table->timestamps();
        // });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique()->nullable(); // Custom patient ID: P-001, P-002
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('husband_wife_name')->nullable()->comment('For married patients');
            $table->string('occupation')->nullable();

            // Bangladeshi address fields
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('union')->nullable();
            $table->string('village')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->text('full_address')->nullable();

            // Medical information
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'])->nullable();
            $table->enum('marital_status', ['Unmarried', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Other'])->nullable();
            $table->string('nationality')->default('Bangladeshi');
            $table->string('nid')->nullable()->comment('National ID Card Number');
            $table->string('birth_certificate_no')->nullable();

            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();

            // Medical history
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('past_medical_history')->nullable();
            $table->text('family_medical_history')->nullable();
            $table->text('habits')->nullable()->comment('Smoking, Alcohol, etc.');

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();

            $table->index('patient_id');
            $table->index('phone');
            $table->index('name');
            $table->index(['district', 'upazila']);
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('appointment_time');
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['doctor_id', 'appointment_time']);
            $table->index('appointment_time');
            $table->index('status');
            $table->index(['doctor_id', 'status']); // Added for performance
            $table->index(['patient_id', 'status']); // Added for performance
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->unique('appointment_id');
            $table->text('visit_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('appointment_id'); // Added for performance
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('pdf_path')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('consultation_id'); // Added for performance
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->string('medicine_name');
            $table->string('dosage', 100);
            $table->string('duration', 100)->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->string('pdf_path')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('consultation_id'); // Added for performance
            $table->index('payment_status'); // Added for performance
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('service_description');
            $table->decimal('fee', 10, 2);
            $table->timestamps();
        });

        // Schema::create('permissions', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name')->unique();
        //     $table->string('display_name');
        //     $table->text('description')->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('permission_role', function (Blueprint $table) {
        //     $table->foreignId('permission_id')->constrained()->onDelete('cascade');
        //     $table->foreignId('role_id')->constrained()->onDelete('cascade');
        //     $table->primary(['permission_id', 'role_id']);
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('permission_role');
        // Schema::dropIfExists('permissions');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('patients');
        // Schema::dropIfExists('role_user');
        // Schema::dropIfExists('roles');
    }
};
