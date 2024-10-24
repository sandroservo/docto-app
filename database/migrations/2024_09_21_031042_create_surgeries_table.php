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
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();

            // Surgery data
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('name')->nullable();

            $table->string('age')->nullable();

            $table->foreignId('citie_id')
                ->index()
                ->constrained('cities')
                ->cascadeOnDelete()->nullable();

            // Relacionamentos com estados e cidades
            $table->foreignId('state_id')
                ->index()
                ->constrained('states')
                ->cascadeOnDelete()->nullable();
                
            // Relacionamentos com o profissional
            $table->foreignId('anestesista_id')
                ->index()
                ->constrained('professionals')
                ->cascadeOnDelete()->nullable();

            $table->foreignId('cirurgiao_id')
                ->index()
                ->constrained('professionals')
                ->cascadeOnDelete()->nullable();

            $table->foreignId('pediatra_id')
                ->index()
                ->constrained('professionals')
                ->cascadeOnDelete()->nullable();

            $table->foreignId('enfermeiro_id')
                ->index()
                ->constrained('professionals')
                ->cascadeOnDelete()->nullable();


            $table->foreignId('indication_id')
                ->index()
                ->constrained('indications')
                ->cascadeOnDelete()->nullable();

            $table->foreignId('surgery_id') // corrected from 'surgerie_id'
                ->index()
                ->constrained('surgery_types')
                ->cascadeOnDelete()->nullable();

            // Additional surgery data
            $table->string('medical_record')->nullable();
            $table->date('admission_date')->nullable();
            $table->time('admission_time')->nullable();

            // Information about origin and indication
            $table->string('origin_department')->nullable();

            // Type of anesthesia and responsible professional
            $table->string('anesthesia', 2)->nullable();; // RA, S, GE, I, E (use an enum in the model)

            // Other professionals involved
            $table->string('apgar')->nullable();

            // End time and ligation
            $table->time('end_time')->nullable();
            $table->boolean('ligation')->default(false);

            // Social information (can be enum or tinyInt depending on the context)
            $table->string('social_status', 50)->nullable(); // A = High, M = Medium, B = Low

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgeries');
    }
};
