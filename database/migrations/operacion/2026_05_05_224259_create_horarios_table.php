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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->foreignId('id_grupo')->constrained('grupos', 'id_grupo')->onDelete('cascade');
            $table->enum('dia_semana', [
                'lunes',
                'martes',
                'miercoles',
                'jueves',
                'viernes'
            ]);
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('salon', 20)->nullable();
            $table->timestamps();

            // Evitar horarios duplicados para el mismo grupo
            $table->unique(['id_grupo', 'dia_semana', 'hora_inicio'], 'unique_horario_grupo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
