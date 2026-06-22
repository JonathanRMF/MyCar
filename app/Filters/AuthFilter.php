<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesión activa → mandamos al login
        if (!session()->get('usuario_id')) {
            return redirect()->to('/login')->with('error', 'Debés iniciar sesión para continuar.');
        }

        // Si se pasó un argumento de rol (ej: 'admin') → verificamos el rol
        if ($arguments && !in_array(session()->get('rol'), $arguments)) {
            return redirect()->to('/')->with('error', 'No tenés permisos para acceder a esa sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos hacer nada después de la respuesta
    }
}