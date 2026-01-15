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
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medical_file_id')->constrained()->cascadeOnDelete();
            $table->foreignId('etablissement_id')->constrained()->cascadeOnDelete();

            $table->string('service')->nullable(); // Médecine, Chirurgie…
            $table->string('room')->nullable();
            $table->string('bed')->nullable();

            $table->dateTime('admitted_at');
            $table->dateTime('discharged_at')->nullable();

            $table->enum('status', ['admitted', 'discharged'])->default('admitted');

            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalizations');
    }
};
