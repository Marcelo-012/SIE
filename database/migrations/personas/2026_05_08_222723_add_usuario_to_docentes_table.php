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
        Schema::table('docentes', function (Blueprint $table) {
            // Se añade después de rfc para agruparlo con los campos de acceso
            $table->string('usuario')->unique()->after('rfc');
        });
    }

    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropUnique(['usuario']);
            $table->dropColumn('usuario');
        });
    }
};
