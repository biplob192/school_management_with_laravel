<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Basic info
            $table->string('employee_id')->nullable()->unique()->comment('Unique employee ID assigned by the school');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onDelete('set null')->comment('Job title, e.g., Assistant Teacher, Headmaster');
            $table->string('qualification')->nullable();
            $table->foreignId('basic_subject_id')->nullable()->constrained('subjects')->onDelete('set null');

            // Personal info
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('national_id')->nullable();

            // Contact
            $table->string('phone')->nullable()->comment('Personal contact number (alternative to user.phone)');
            $table->string('emergency_contact')->nullable()->comment('Emergency contact number');

            // Employment details
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);

            // Optional media/info
            $table->string('signature')->nullable();
            $table->text('biography')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
