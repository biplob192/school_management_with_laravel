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
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('subject_teacher_id')->nullable()->constrained('subject_teachers')->onDelete('set null');

            // Mark breakdowns
            $table->unsignedTinyInteger('written')->nullable();
            $table->unsignedTinyInteger('mcq')->nullable();
            $table->unsignedTinyInteger('practical')->nullable();
            $table->unsignedTinyInteger('viva')->nullable();
            $table->unsignedTinyInteger('assessment')->nullable();
            $table->unsignedTinyInteger('other')->nullable();

            // Results
            $table->unsignedSmallInteger('total')->nullable();
            $table->decimal('gpa', 3, 2)->nullable()->comment('Grade Point for the subject in this exam');
            $table->string('grade', 5)->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->unique(['student_id', 'exam_id', 'subject_teacher_id'], 'unique_mark_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_marks');
    }
};
