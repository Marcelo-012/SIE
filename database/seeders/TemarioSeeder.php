<?php

namespace Database\Seeders;

use App\Models\Materia;
use App\Models\UnidadTemario;
use Illuminate\Database\Seeder;

class TemarioSeeder extends Seeder
{
    public function run(): void
    {
        $temarios = [
            'ACA-0910' => [
                ['numero' => 1, 'titulo' => 'Fundamentos de la Investigación',
                 'descripcion' => 'Introducción al método científico, tipos de investigación y planteamiento del problema de estudio.'],
                ['numero' => 2, 'titulo' => 'Desarrollo del Protocolo de Investigación',
                 'descripcion' => 'Marco teórico, hipótesis, variables y diseño metodológico de la investigación.'],
                ['numero' => 3, 'titulo' => 'Presentación y Defensa del Protocolo',
                 'descripcion' => 'Redacción del informe final, exposición oral y estrategias de defensa ante comité evaluador.'],
            ],
            'SCC-1016' => [
                ['numero' => 1, 'titulo' => 'Modelo Entidad-Relación',
                 'descripcion' => 'Conceptos de bases de datos relacionales, modelado ER y normalización de esquemas.'],
                ['numero' => 2, 'titulo' => 'Lenguaje SQL',
                 'descripcion' => 'DDL, DML y DQL: creación de tablas, consultas básicas y avanzadas.'],
                ['numero' => 3, 'titulo' => 'Procedimientos y Transacciones',
                 'descripcion' => 'Stored procedures, triggers, vistas y control de transacciones ACID.'],
                ['numero' => 4, 'titulo' => 'Optimización y Administración',
                 'descripcion' => 'Índices, planes de ejecución, respaldos y seguridad en sistemas de bases de datos.'],
            ],
            'SCD-1027' => [
                ['numero' => 1, 'titulo' => 'Fundamentos de la Web',
                 'descripcion' => 'HTML5, CSS3 y JavaScript: estructura, estilos y comportamiento de páginas web.'],
                ['numero' => 2, 'titulo' => 'Desarrollo del lado del Servidor',
                 'descripcion' => 'PHP y frameworks MVC: rutas, controladores, modelos y ORM.'],
                ['numero' => 3, 'titulo' => 'Aplicaciones Web Dinámicas',
                 'descripcion' => 'AJAX, APIs REST, autenticación y despliegue de aplicaciones web.'],
            ],
        ];

        $objetivos = [
            'ACA-0910' => 'CONSOLIDA EL PROTOCOLO PARA EJECUTAR LA INVESTIGACIÓN Y OBTENER PRODUCTOS PARA SU EXPOSICIÓN, DEFENSA Y GESTIÓN DE SU TRANSCENDENCIA.',
            'SCC-1016' => 'DISEÑA, IMPLEMENTA Y ADMINISTRA BASES DE DATOS RELACIONALES APLICANDO LOS PRINCIPIOS DE NORMALIZACIÓN Y LAS OPERACIONES DEL LENGUAJE SQL.',
            'SCD-1027' => 'DESARROLLA APLICACIONES WEB DINÁMICAS INTEGRANDO TECNOLOGÍAS DEL LADO DEL CLIENTE Y DEL SERVIDOR BAJO UN ENFOQUE MVC.',
        ];

        foreach ($temarios as $clave => $unidades) {
            $materia = Materia::where('clave_materia', $clave)->first();
            if (!$materia) continue;

            if (!$materia->objetivo && isset($objetivos[$clave])) {
                $materia->update(['objetivo' => $objetivos[$clave]]);
            }

            foreach ($unidades as $u) {
                UnidadTemario::updateOrCreate(
                    ['id_materia' => $materia->id_materia, 'numero' => $u['numero']],
                    ['titulo' => $u['titulo'], 'descripcion' => $u['descripcion']]
                );
            }
        }

        $this->command->info('TemarioSeeder: unidades de temario y objetivos insertados.');
    }
}
