<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class VehiculoController extends BaseController
{
    public function index()
    {
        $model = new VehiculoModel();

        $data = [
            'vehiculos'  => $model->disponiblesParaAlquilar(),
            'categorias' => ['Auto', 'Camioneta', 'SUV', 'Deportivo', 'Van'],
        ];

        return view('layout/nav') . view('vehiculos/lista', $data) . view('layout/footer');
    }

    public function buscar()
    {
        $model      = new VehiculoModel();
        $q          = $this->request->getGet('q');
        $categoria  = $this->request->getGet('categoria');
        $precioMin  = $this->request->getGet('precio_min');
        $precioMax  = $this->request->getGet('precio_max');
        $plazas     = $this->request->getGet('plazas');

        $builder = $model->where('activo', 1)->where('disponible', 1);

        if ($q) {
            $builder->groupStart()
                        ->like('marca', $q)
                        ->orLike('modelo', $q)
                        ->orLike('descripcion', $q)
                    ->groupEnd();
        }
        if ($categoria) {
            $builder->where('categoria', $categoria);
        }
        if ($precioMin) {
            $builder->where('precio_dia >=', (float) $precioMin);
        }
        if ($precioMax) {
            $builder->where('precio_dia <=', (float) $precioMax);
        }
        if ($plazas) {
            $builder->where('plazas >=', (int) $plazas);
        }

        $data = [
            'vehiculos'      => $builder->findAll(),
            'categorias'     => ['Auto', 'Camioneta', 'SUV', 'Deportivo', 'Van'],
            'busqueda'       => [
                'q'          => $q,
                'categoria'  => $categoria,
                'precio_min' => $precioMin,
                'precio_max' => $precioMax,
                'plazas'     => $plazas,
            ],
        ];

        return view('layout/nav') . view('vehiculos/lista', $data) . view('layout/footer');
    }

    public function porCategoria(string $categoria)
    {
        $model = new VehiculoModel();

        $data = [
            'vehiculos'       => $model->getPorCategoria($categoria),
            'categorias'      => ['Auto', 'Camioneta', 'SUV', 'Deportivo', 'Van'],
            'categoriaActual' => $categoria,
        ];

        return view('layout/nav') . view('vehiculos/lista', $data) . view('layout/footer');
    }

    public function detalle(int $id)
    {
        $model    = new VehiculoModel();
        $vehiculo = $model->find($id);

        if (!$vehiculo || !$vehiculo['activo']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('layout/nav') . view('vehiculos/detalle', ['vehiculo' => $vehiculo]) . view('layout/footer');
    }

    // ── ADMIN ─────────────────────────────────────────────────

    public function adminIndex()
    {
        $model = new VehiculoModel();
        $data  = ['vehiculos' => $model->findAll()];
        return view('layout/nav') . view('admin/vehiculos/lista', $data) . view('layout/footer');
    }

    public function crear()
    {
        return view('layout/nav') . view('admin/vehiculos/form', ['vehiculo' => null]) . view('layout/footer');
    }

    public function crearPost()
    {
        $rules = [
            'marca'       => 'required|min_length[2]|max_length[60]',
            'modelo'      => 'required|min_length[2]|max_length[60]',
            'categoria'   => 'required',
            'anio'        => 'required|integer|greater_than_equal_to[1990]|less_than_equal_to[2026]',
            'precio_dia'  => 'required|decimal|greater_than[0]',
            'plazas'      => 'required|integer|greater_than[0]',
            'kilometraje' => 'permit_empty|integer|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/vehiculos/crear'))
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $model = new VehiculoModel();
        $model->insert([
            'marca'       => $this->request->getPost('marca'),
            'modelo'      => $this->request->getPost('modelo'),
            'categoria'   => $this->request->getPost('categoria'),
            'anio'        => $this->request->getPost('anio'),
            'plazas'      => $this->request->getPost('plazas'),
            'motor'       => $this->request->getPost('motor'),
            'kilometraje' => $this->request->getPost('kilometraje'),
            'precio_dia'  => $this->request->getPost('precio_dia'),
            'descripcion' => $this->request->getPost('descripcion'),
            'imagen'      => $this->request->getPost('imagen'),
            'activo'      => 1,
            'disponible'  => 1,
        ]);

        return redirect()->to(base_url('admin/vehiculos'))
            ->with('exito', 'Vehículo creado correctamente.');
    }

    public function editar(int $id)
    {
        $model    = new VehiculoModel();
        $vehiculo = $model->find($id);

        if (!$vehiculo) {
            return redirect()->to(base_url('admin/vehiculos'))
                ->with('error', 'Vehículo no encontrado.');
        }

        return view('layout/nav') . view('admin/vehiculos/form', ['vehiculo' => $vehiculo]) . view('layout/footer');
    }

    public function editarPost(int $id)
    {
        $rules = [
            'marca'       => 'required|min_length[2]|max_length[60]',
            'modelo'      => 'required|min_length[2]|max_length[60]',
            'categoria'   => 'required',
            'anio'        => 'required|integer|greater_than_equal_to[1990]|less_than_equal_to[2026]',
            'precio_dia'  => 'required|decimal|greater_than[0]',
            'plazas'      => 'required|integer|greater_than[0]',
            'kilometraje' => 'permit_empty|integer|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url("admin/vehiculos/editar/$id"))
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $model = new VehiculoModel();
        $model->update($id, [
            'marca'       => $this->request->getPost('marca'),
            'modelo'      => $this->request->getPost('modelo'),
            'categoria'   => $this->request->getPost('categoria'),
            'anio'        => $this->request->getPost('anio'),
            'plazas'      => $this->request->getPost('plazas'),
            'motor'       => $this->request->getPost('motor'),
            'kilometraje' => $this->request->getPost('kilometraje'),
            'precio_dia'  => $this->request->getPost('precio_dia'),
            'descripcion' => $this->request->getPost('descripcion'),
            'imagen'      => $this->request->getPost('imagen'),
        ]);

        return redirect()->to(base_url('admin/vehiculos'))
            ->with('exito', 'Vehículo actualizado correctamente.');
    }

    public function bajaLogica(int $id)
    {
        $model = new VehiculoModel();
        $model->bajaLogica($id);
        return redirect()->to(base_url('admin/vehiculos'))
            ->with('exito', 'Vehículo dado de baja correctamente.');
    }
}