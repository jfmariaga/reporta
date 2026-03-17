<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipo_apoyos', function (Blueprint $table) {
            $table->boolean('activo')
                ->default(true)
                ->after('apoyo_id');
        });
    }

    public function down(): void
    {
        Schema::table('equipo_apoyos', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};
