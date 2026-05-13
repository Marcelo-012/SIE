<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->string('plan_estudios', 120)->nullable()->after('nombre_materia');
            $table->string('departamento', 120)->nullable()->after('plan_estudios');
            $table->string('idioma', 30)->default('Español')->after('departamento');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropColumn(['plan_estudios', 'departamento', 'idioma']);
        });
    }
};
