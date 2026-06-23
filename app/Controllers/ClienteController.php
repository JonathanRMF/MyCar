<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class ClienteController extends BaseController
{
    public function adminIndex()
    {
        $model = new ClienteModel();
        $data  = ['clientes' => $model->findAll()];
        return view('layout/nav') . view('admin/clientes/lista', $data) . view('layout/footer');
    }

    public function crear()
    {
        return view('layout/nav') . view('admin/clientes/form', ['cliente' => null]) . view('layout/footer');
    }

    public function crearPost()
    {
        $rules = [
            'nombre'    => 'required|min_length[2]|max_length[100]',
            'apellido'  => 'required|min_length[2]|max_length[100]',
            'direccion' => 'permit_empty|max_length[200]',
            'telefono'  => 'required|min_length[6]|max_length[30]',
            'email'     => 'required|valid_email|is_unique[usuarios.email]',
            'password'  => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/clientes/crear'))
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $usuarioModel = new UsuarioModel();
        $clienteModel = new ClienteModel();

        // 1) Crear usuario
        $usuarioId = $usuarioModel->insert([
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'      => 'cliente',
        ]);

        // 2) Crear cliente vinculado
        $clienteModel->insert([
            'usuario_id' => $usuarioId,
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'fecha_alta' => date('Y-m-d'),
            'activo'     => 1,
        ]);

        return redirect()->to(base_url('admin/clientes'))
            ->with('exito', 'Cliente creado correctamente.');
    }

    public function editar(int $id)
    {
        $model   = new ClienteModel();
        $cliente = $model->find($id);

        if (!$cliente) {
            return redirect()->to(base_url('admin/clientes'))
                ->with('error', 'Cliente no encontrado.');
        }

        return view('layout/nav') . view('admin/clientes/form', ['cliente' => $cliente]) . view('layout/footer');
    }

    public function editarPost(int $id)
    {
        $rules = [
            'nombre'    => 'required|min_length[2]|max_length[100]',
            'apellido'  => 'required|min_length[2]|max_length[100]',
            'direccion' => 'permit_empty|max_length[200]',
            'telefono'  => 'required|min_length[6]|max_length[30]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url("admin/clientes/editar/$id"))
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $model = new ClienteModel();
        $model->update($id, [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'direccion' => $this->request->getPost('direccion'),
            'telefono'  => $this->request->getPost('telefono'),
        ]);

        return redirect()->to(base_url('admin/clientes'))
            ->with('exito', 'Cliente actualizado correctamente.');
    }

    public function bajaLogica(int $id)
    {
        $model   = new ClienteModel();
        $cliente = $model->find($id);

        if (!$cliente) {
            return redirect()->to(base_url('admin/clientes'))
                ->with('error', 'Cliente no encontrado.');
        }

        $model->bajaLogica($id);

        return redirect()->to(base_url('admin/clientes'))
            ->with('exito', 'Cliente dado de baja correctamente.');
    }
}