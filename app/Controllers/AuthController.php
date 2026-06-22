<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ClienteModel;

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

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->findByEmail($email);

        // Verificamos que exista el usuario y que la contraseña sea correcta
        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()->to('/login')
                ->with('error', 'Email o contraseña incorrectos.');
        }

        if (!$usuario['activo']) {
            return redirect()->to('/login')
                ->with('error', 'Tu cuenta está desactivada.');
        }

        // Guardamos los datos en la sesión
        session()->set([
            'usuario_id' => $usuario['id'],
            'nombre'     => $usuario['nombre'],
            'rol'        => $usuario['rol'],
        ]);

        // Redirigimos según el rol
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

        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        // Verificamos que el email no esté registrado
        if ($usuarioModel->findByEmail($this->request->getPost('email'))) {
            return redirect()->to('/register')
                ->with('error', 'Ese email ya está registrado.');
        }

        // 1) Creamos el usuario
        $usuarioId = $usuarioModel->insert([
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => 'cliente',
            'activo'   => 1,
        ]);

        // 2) Creamos el cliente vinculado al usuario
        $clienteModel->insert([
            'usuario_id' => $usuarioId,
            'apellido'   => $this->request->getPost('apellido'),
            'nombre'     => $this->request->getPost('nombre'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'fecha_alta' => date('Y-m-d'),
            'activo'     => 1,
        ]);

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