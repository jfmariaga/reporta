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
        Schema::create('equipo_apoyos', function (Blueprint $table) {
            $table->id();

            // Responsable principal (jefe de gestión)
            $table->foreignId('responsable_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Usuario que hace parte del equipo de apoyo
            $table->foreignId('apoyo_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_apoyos');
    }
};
