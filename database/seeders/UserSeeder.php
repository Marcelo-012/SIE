<?php

namespace Database\Seeders;

use App\Models\personas\Alumno;
use App\Models\personas\Docente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Docente de prueba ──────────────────────────────────────────────
        Docente::updateOrCreate(
            ['usuario' => 'edgar.garcia'],
            [
                'rfc'          => 'GAVE770101ABC',
                'usuario'      => 'edgar.garcia',
                'nombre'       => 'Edgar Luis',
                'apellido_pat' => 'Garcia',
                'apellido_mat' => 'Vargas',
                'password'     => Hash::make('password123'),
                'status'       => 'activo',
            ]
        );

        // ── Alumno de prueba ───────────────────────────────────────────────
        Alumno::updateOrCreate(
            ['matricula' => '22730346'],
            [
                'matricula'       => '22730346',
                'nombre'          => 'Marcelo Emmanuel',
                'apellido_pat'    => 'Rivero',
                'apellido_mat'    => 'Martinez',
                'password'        => Hash::make('password123'),
                'fecha_nacimiento' => '2004-09-19',
                'curp'            => 'RIMM040919HMNVRC09',
                'genero'          => 'masculino',
                'estado_civil'    => 'soltero',
                'calle_y_numero'  => 'Av. Tecnológico 100',
                'colonia'         => 'Centro',
                'municipio'       => 'Monterrey',
                'estado'          => 'Nuevo León',
                'codigo_postal'   => '64000',
                'telefono'        => '8110000000',
                'correo'          => 'marcelo@example.com',
                'carrera'         => 'Ingenieria en Sistemas Computacionales',
                'especialidad'    => 'Sin especialidad',
                'status'          => 'activo',
            ]
        );
    }
}
