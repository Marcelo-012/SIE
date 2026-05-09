<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Primero eliminar el índice existente para poder modificar la columna
            $table->dropIndex('sessions_user_id_index');

            // Cambiar de unsignedBigInteger a string(255) para soportar
            // identificadores de tipo texto (usuario, matrícula)
            $table->string('user_id', 255)->nullable()->change();

            // Recrear el índice sobre el nuevo tipo string
            $table->index('user_id', 'sessions_user_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex('sessions_user_id_index');

            // Vaciar la tabla antes de revertir: los valores string
            // no caben en unsignedBigInteger
            \DB::table('sessions')->truncate();

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->index('user_id', 'sessions_user_id_index');
        });
    }
};
