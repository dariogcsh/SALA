<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'utilidad/informe',
        'reparacion/solicitudes/solicitar_reparacion/mobile',
        'reparacion/tareas/campo/crear/mobile',
        'reparacion/tareas/taller/crear/mobile',
        'mobile/login',
        'reparacion/solicitudes/pdf/{id}',
        'reparacion/tareas/campo/pdf/{id}',
        'reparacion/tareas/taller/pdf/{id}'
    ];
}
