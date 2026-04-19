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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 25)->nullable();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->boolean('is_common_group')->default(false);
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('set null');
            $table->boolean('is_common_section')->default(false);
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
            $table->unsignedTinyInteger('written_mark')->default(0);
            $table->unsignedTinyInteger('written_pass_mark')->default(0);
            $table->unsignedTinyInteger('mcq_mark')->default(0);
            $table->unsignedTinyInteger('mcq_pass_mark')->default(0);
            $table->unsignedTinyInteger('practical_mark')->default(0);
            $table->unsignedTinyInteger('practical_pass_mark')->default(0);
            $table->unsignedTinyInteger('viva_mark')->default(0);
            $table->unsignedTinyInteger('viva_pass_mark')->default(0);
            $table->unsignedTinyInteger('assessment_mark')->default(0);
            $table->unsignedTinyInteger('assessment_pass_mark')->default(0);
            $table->unsignedTinyInteger('other_mark')->default(0);
            $table->unsignedSmallInteger('total_mark')->default(0);
            $table->unsignedSmallInteger('pass_mark')->default(0);
            $table->unsignedSmallInteger('pass_mark_percent')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add composite unique constraint
            $table->unique(['name', 'class_id', 'section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
