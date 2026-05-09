<?php

use App\Models\personas\Alumno;
use App\Models\personas\Docente;
use App\Models\User;

return [

    'defaults' => [
        'guard'     => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Guard para docentes / personal
        'docente' => [
            'driver'   => 'session',
            'provider' => 'docentes',
        ],

        // Guard para alumnos / aspirantes
        'alumno' => [
            'driver'   => 'session',
            'provider' => 'alumnos',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => env('AUTH_MODEL', User::class),
        ],

        'docentes' => [
            'driver' => 'eloquent',
            'model'  => Docente::class,
        ],

        'alumnos' => [
            'driver' => 'eloquent',
            'model'  => Alumno::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider'  => 'users',
            'table'     => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'    => 60,
            'throttle'  => 60,
        ],

        'docentes' => [
            'provider'  => 'docentes',
            'table'     => 'password_reset_tokens',
            'expire'    => 60,
            'throttle'  => 60,
        ],

        'alumnos' => [
            'provider'  => 'alumnos',
            'table'     => 'password_reset_tokens',
            'expire'    => 60,
            'throttle'  => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
