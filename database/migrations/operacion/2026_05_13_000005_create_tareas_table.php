<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id('id_tarea');
            $table->unsignedBigInteger('id_grupo');
            $table->unsignedTinyInteger('numero_unidad');
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->timestamps();

            $table->foreign('id_grupo')->references('id_grupo')->on('grupos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
