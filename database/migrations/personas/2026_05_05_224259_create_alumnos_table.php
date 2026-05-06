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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id('id_alumno');
            $table->string('matricula')->unique();
            $table->string('nombre', 30);
            $table->string('apellido_pat', 30);
            $table->string('apellido_mat', 30);
            $table->date('fecha_nacimiento');
            $table->string('curp')->unique();
            $table->enum('genero', ['masculino', 'femenino']);
            $table->enum('estado_civil', [
                'soltero',
                'casado',
                'divorciado',
                'viudo',
                'otro'
            ]);

            $table->string('calle y numero', 100);
            $table->string('colonia', 50);
            $table->string('municipio', 50);
            $table->string('estado', 30);
            $table->string('codigo_postal', 5);

            $table->string('telefono', 10);
            $table->string('correo')->unique();
            $table->enum('carrera', [
                'Ingenieria en Sistemas Computacionales',
                'Ingeniria Industrial',
                'Administración',
                'Ingeniria en Agronomia',
                'Contador Publico',
                'Gestión Empresarial'
            ]);
            $table->string('especialidad', 30);
            $table->enum('status', ['activo', 'inactivo'])->default('activo');

            $table->string('password', 60);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
