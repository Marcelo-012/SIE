<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->integer('cal_diagnostica')->nullable()->after('califiacion_final');
            $table->integer('cal_reporte_intermedio')->nullable()->after('cal_diagnostica');
        });
    }

    public function down(): void
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            $table->dropColumn(['cal_diagnostica', 'cal_reporte_intermedio']);
        });
    }
};
