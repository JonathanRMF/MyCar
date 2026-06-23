<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ClienteModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(base_url('vehiculos'));
        }
        return view('layout/nav') . view('auth/login') . view('layout/footer');
    }

    public function loginProcess()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuarioModel = new UsuarioModel();
        $usuario      = $usuarioModel->findByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password'])) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Email o contraseña incorrectos.');
        }

        if (isset($usuario['activo']) && !$usuario['activo']) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Tu cuenta está desactivada.');
        }

        session()->set([
            'usuario_id' => $usuario['id'],
            'nombre'     => $usuario['nombre'],
            'rol'        => $usuario['rol'],
        ]);

        if ($usuario['rol'] === 'admin') {
            return redirect()->to(base_url('admin/vehiculos'));
        }
        return redirect()->to(base_url('vehiculos'));
    }

    public function register()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(base_url('vehiculos'));
        }
        return view('layout/nav') . view('auth/register') . view('layout/footer');
    }

    public function registerProcess()
    {
        $rules = [
            'nombre'    => 'required|min_length[3]',
            'email'     => 'required|valid_email',
            'password'  => 'required|min_length[6]',
            'confirmar' => 'required|matches[password]',
            'apellido'  => 'required',
            'telefono'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('register'))
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        if ($usuarioModel->findByEmail($this->request->getPost('email'))) {
            return redirect()->to(base_url('register'))
                ->with('error', 'Ese email ya está registrado.')
                ->withInput();
        }

        // 1) Crear usuario primero
        $usuarioId = $usuarioModel->insert([
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => 'cliente',
        ]);

        // 2) Crear cliente vinculado al usuario
        $clienteModel->insert([
            'usuario_id' => $usuarioId,
            'apellido'   => $this->request->getPost('apellido'),
            'nombre'     => $this->request->getPost('nombre'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'fecha_alta' => date('Y-m-d'),
            'activo'     => 1,
        ]);

        return redirect()->to(base_url('login'))
            ->with('exito', 'Cuenta creada con éxito. Ya podés iniciar sesión.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))
            ->with('exito', 'Sesión cerrada correctamente.');
    }
}