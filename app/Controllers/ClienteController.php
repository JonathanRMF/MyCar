<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Services\UsuarioService;

class ClienteController extends BaseController
{
    public function adminIndex()
    {
        $model   = new ClienteModel();
        $data    = ['clientes' => $model->findAll()];
        return view('layout/nav') . view('admin/clientes/lista', $data) . view('layout/footer');
    }

    public function crear()
    {
        return view('layout/nav') . view('admin/clientes/form', ['cliente' => null]) . view('layout/footer');
    }

    public function crearPost()
    {
        $rules = [
            'nombre'   => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/clientes/crear')
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
            return redirect()->to('/admin/clientes/crear')
                ->with('errores', $usuarioService->getErrors())
                ->withInput();
        }

        return redirect()->to('/admin/clientes')
            ->with('exito', 'Cliente creado correctamente.');
    }

    public function editar(int $id)
    {
        $model   = new ClienteModel();
        $cliente = $model->find($id);

        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'Cliente no encontrado.');
        }

        return view('layout/nav') . view('admin/clientes/form', ['cliente' => $cliente]) . view('layout/footer');
    }

    public function editarPost(int $id)
    {
        $rules = [
            'nombre'   => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to("/admin/clientes/editar/$id")
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

        return redirect()->to('/admin/clientes')
            ->with('exito', 'Cliente actualizado correctamente.');
    }

    public function bajaLogica(int $id)
    {
        $model = new ClienteModel();
        $model->bajaLogica($id);
        return redirect()->to('/admin/clientes')
            ->with('exito', 'Cliente dado de baja correctamente.');
    }
}