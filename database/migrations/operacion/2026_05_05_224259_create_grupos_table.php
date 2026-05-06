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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id('id_grupo');
            $table->foreignId('id_materia')->constrained('materias', 'id_materia');
            $table->foreignId('id_docente')->constrained('docentes', 'id_docente');
            $table->foreignId('id_ciclo_escolar')->constrained('ciclo_escolares', 'id_ciclo_escolar');
            $table->string('letra', 1);
            $table->string('salon', 2);
            $table->integer('cupo')->default(0);
            $table->integer('cupo_max');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Un grupo por materia, ciclo y letra
            $table->unique(['id_materia', 'id_ciclo_escolar', 'letra']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
