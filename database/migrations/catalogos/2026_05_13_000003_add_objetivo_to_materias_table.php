<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->text('objetivo')->nullable()->after('idioma');
            $table->text('caracterizacion')->nullable()->after('objetivo');
            $table->text('intencion_didactica')->nullable()->after('caracterizacion');
            $table->longText('bibliografia')->nullable()->after('intencion_didactica');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropColumn(['objetivo', 'caracterizacion', 'intencion_didactica', 'bibliografia']);
        });
    }
};
