<?php

namespace App\Controllers;

use App\Services\UsuarioService;

class AuthController extends BaseController
{
    // ── Mostrar formulario de login ──────────────────────────
    public function login()
    {
        // Si ya está logueado, no tiene sentido mostrar el login
        if (session()->get('usuario_id')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    // ── Procesar el formulario de login ──────────────────────
    public function loginProcess()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuarioService = new UsuarioService();
        $usuario = $usuarioService->login($email, $password);

        if (!$usuario) {
            return redirect()->to('/login')
                ->with('error', $usuarioService->getErrors()['login'] ?? 'Email o contraseña incorrectos.');
        }

        session()->set([
            'usuario_id' => $usuario['id'],
            'nombre'     => $usuario['nombre'],
            'rol'        => $usuario['rol'],
        ]);

        if ($usuario['rol'] === 'admin') {
            return redirect()->to('/admin/vehiculos');
        }
        return redirect()->to('/vehiculos');
    }

    // ── Mostrar formulario de registro ───────────────────────
    public function register()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to('/');
        }
        return view('auth/register');
    }

    // ── Procesar el registro ─────────────────────────────────
    public function registerProcess()
    {
        // Validaciones
        $rules = [
            'nombre'   => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'confirmar'=> 'required|matches[password]',
            'apellido' => 'required',
            'telefono' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $usuarioService = new UsuarioService();

        $usuarioId = $usuarioService->registerClientUser(
            [
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'rol'      => 'cliente',
            ],
            [
                'nombre'     => $this->request->getPost('nombre'),
                'apellido'   => $this->request->getPost('apellido'),
                'direccion'  => $this->request->getPost('direccion'),
                'telefono'   => $this->request->getPost('telefono'),
                'fecha_alta' => date('Y-m-d'),
                'activo'     => 1,
            ]
        );

        if ($usuarioId === false) {
            return redirect()->to('/register')
                ->with('errores', $usuarioService->getErrors())
                ->withInput();
        }

        return redirect()->to('/login')
            ->with('exito', 'Cuenta creada con éxito. Ya podés iniciar sesión.');
    }

    // ── Cerrar sesión ────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')
            ->with('exito', 'Sesión cerrada correctamente.');
    }
}