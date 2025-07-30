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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string("ReportadoPor");
            $table->bigInteger('cargo_id')->unsigned();
            $table->string('area');
            $table->text('zona');
            $table->text('impactos');
            $table->text("descripcion");
            $table->string("prioridad");
            $table->string("orden")->nullable();
            $table->tinyInteger("estado")->nullable();
            $table->bigInteger("responsable_id")->unsigned()->nullable();
            $table->bigInteger("colaborador_id")->unsigned()->nullable();
            $table->text("resuesta")->nullable();
            $table->text("adjunto");
            $table->text("consecutivo");
            $table->text("adjunto_after")->nullable();
            $table->timestamps();

            $table->foreign('responsable_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('colaborador_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cargo_id')->references('id')->on('cargos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
