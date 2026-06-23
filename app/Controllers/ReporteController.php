<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;

class ReporteController extends BaseController
{
    public function index()
    {
        $vehiculoModel = new VehiculoModel();
        $clienteModel  = new ClienteModel();

        $data = [
            'vehiculos' => $vehiculoModel->findAll(),
            'clientes'  => $clienteModel->findAll(),
        ];

        return view('layout/nav') . view('admin/reportes/index', $data) . view('layout/footer');
    }

    public function porVehiculo(int $vehiculoId)
    {
        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        $vehiculo = $vehiculoModel->find($vehiculoId);
        if (!$vehiculo) {
            return redirect()->to(base_url('admin/reportes'))
                ->with('error', 'Vehículo no encontrado.');
        }

        $data = [
            'vehiculo'   => $vehiculo,
            'alquileres' => $alquilerModel->getPorVehiculo($vehiculoId),
        ];

        return view('layout/nav') . view('admin/reportes/por_vehiculo', $data) . view('layout/footer');
    }

    public function porCliente(int $clienteId)
    {
        $alquilerModel = new AlquilerModel();
        $clienteModel  = new ClienteModel();

        $cliente = $clienteModel->find($clienteId);
        if (!$cliente) {
            return redirect()->to(base_url('admin/reportes'))
                ->with('error', 'Cliente no encontrado.');
        }

        $data = [
            'cliente'    => $cliente,
            'alquileres' => $alquilerModel->getPorCliente($clienteId),
        ];

        return view('layout/nav') . view('admin/reportes/por_cliente', $data) . view('layout/footer');
    }

    public function activos()
    {
        $alquilerModel = new AlquilerModel();
        $data = ['alquileres' => $alquilerModel->getActivos()];

        return view('layout/nav') . view('admin/reportes/activos', $data) . view('layout/footer');
    }
}