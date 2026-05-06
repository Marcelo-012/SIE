<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id('id_docente');

            // DATOS DE REGISTRO (obligatorios)
            $table->string('rfc', 13)->unique();
            $table->string('nombre', 30);
            $table->string('apellido_pat', 30);
            $table->string('apellido_mat', 30);
            $table->string('password');

            // DATOS PARA COMPLETAR DESPUÉS (nullables)
            $table->date('fecha_nacimiento')->nullable();
            $table->string('curp', 18)->unique()->nullable();
            $table->enum('genero', ['masculino', 'femenino'])->nullable();
            $table->enum('estado_civil', [
                'soltero',
                'casado',
                'divorciado',
                'viudo',
                'otro'
            ])->nullable();

            // Dirección
            $table->string('calle_numero', 100)->nullable();  // Sin espacios en nombre columna
            $table->string('colonia', 50)->nullable();
            $table->string('municipio', 50)->nullable();
            $table->string('estado', 30)->nullable();
            $table->string('codigo_postal', 5)->nullable();

            // Contacto y profesional
            $table->string('telefono', 10)->nullable();
            $table->string('correo')->unique()->nullable();
            $table->string('nivel_estudio', 50)->nullable();
            $table->date('antiguedad')->nullable();
            $table->enum('status', ['activo', 'inactivo'])->default('inactivo');

            $table->boolean('perfil_completo')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
