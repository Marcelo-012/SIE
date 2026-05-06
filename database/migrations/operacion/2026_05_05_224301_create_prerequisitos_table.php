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
        Schema::create('materia_prerequisito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias', 'id_materia')->onDelete('cascade');
            $table->foreignId('prerequisito_id')->constrained('materias', 'id_materia')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['materia_id', 'prerequisito_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prerequisitos');
    }
};
