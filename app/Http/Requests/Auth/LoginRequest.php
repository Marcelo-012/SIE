<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // "identificador" acepta usuario, número de control o matrícula
            // sin la regla "email" para evitar el error original
            'identificador' => ['required', 'string', 'max:100'],
            'password'      => ['required', 'string'],
            'rol'           => ['required', 'string', 'in:estudiante,personal,aspirante'],
        ];
    }

    /**
     * Mensajes de validación en español.
     */
    public function messages(): array
    {
        return [
            'identificador.required' => 'El campo de identificación es obligatorio.',
            'password.required'      => 'La contraseña es obligatoria.',
            'rol.required'           => 'Debes seleccionar un tipo de usuario.',
            'rol.in'                 => 'El tipo de usuario seleccionado no es válido.',
        ];
    }

    /**
     * Intenta autenticar las credenciales contra el guard correcto según el rol.
     * Devuelve el nombre del guard usado para que el controlador redirija al dashboard correcto.
     *
     * @throws ValidationException
     */
    public function authenticate(): string
    {
        $this->ensureIsNotRateLimited();

        // Mapeo rol → [guard, columna de la BD]
        [$guard, $columna] = match ($this->string('rol')->toString()) {
            'personal'               => ['docente', 'usuario'],
            'estudiante', 'aspirante' => ['alumno',  'matricula'],
        };

        $credenciales = [
            $columna   => $this->string('identificador')->toString(),
            'password' => $this->string('password')->toString(),
        ];

        if (! Auth::guard($guard)->attempt($credenciales, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identificador' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        return $guard;
    }

    /**
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identificador' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        // Clave única por identificador + IP para limitar intentos
        return Str::transliterate(Str::lower($this->string('identificador')) . '|' . $this->ip());
    }
}
