<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;

class ReporteController extends BaseController
{
    // Página principal — selector de reportes
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

    // Reporte 1: dado un vehículo → todos los clientes que lo alquilaron
    public function porVehiculo(int $vehiculoId)
    {
        $alquilerModel = new AlquilerModel();
        $vehiculoModel = new VehiculoModel();

        $vehiculo   = $vehiculoModel->find($vehiculoId);
        $alquileres = $alquilerModel->getPorVehiculo($vehiculoId);

        $data = [
            'vehiculo'   => $vehiculo,
            'alquileres' => $alquileres,
        ];

        return view('layout/nav') . view('admin/reportes/por_vehiculo', $data) . view('layout/footer');
    }

    // Reporte 2: dado un cliente → todos los vehículos que alquiló
    public function porCliente(int $clienteId)
    {
        $alquilerModel = new AlquilerModel();
        $clienteModel  = new ClienteModel();

        $cliente    = $clienteModel->find($clienteId);
        $alquileres = $alquilerModel->getPorCliente($clienteId);

        $data = [
            'cliente'    => $cliente,
            'alquileres' => $alquileres,
        ];

        return view('layout/nav') . view('admin/reportes/por_cliente', $data) . view('layout/footer');
    }

    // Reporte 3: vehículos actualmente alquilados (no devueltos)
    public function activos()
    {
        $alquilerModel = new AlquilerModel();
        $data = ['alquileres' => $alquilerModel->getActivos()];

        return view('layout/nav') . view('admin/reportes/activos', $data) . view('layout/footer');
    }
}