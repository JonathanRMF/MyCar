<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;

class AlquilerController extends BaseController
{
    // ── CLIENTE ──────────────────────────────────────────────

    public function nuevaReserva(int $vehiculoId)
    {
        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($vehiculoId);

        if (!$vehiculo || !$vehiculo['activo'] || !$vehiculo['disponible']) {
            return redirect()->to(base_url('vehiculos'))
                ->with('error', 'Vehículo no disponible.');
        }

        return view('layout/nav') . view('cliente/reservas/nueva', ['vehiculo' => $vehiculo]) . view('layout/footer');
    }

    public function guardarReserva()
    {
        $rules = [
            'vehiculo_id'   => 'required|integer',
            'fecha_desde'   => 'required|valid_date',
            'cantidad_dias' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->findByUsuarioId(session()->get('usuario_id'));

        if (!$cliente) {
            return redirect()->to(base_url('vehiculos'))
                ->with('error', 'No se encontró tu perfil de cliente.');
        }

        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($this->request->getPost('vehiculo_id'));

        if (!$vehiculo || !$vehiculo['activo'] || !$vehiculo['disponible']) {
            return redirect()->to(base_url('vehiculos'))
                ->with('error', 'El vehículo seleccionado no está disponible.');
        }

        $cantidadDias = (int) $this->request->getPost('cantidad_dias');
        $montoTotal   = $vehiculo['precio_dia'] * $cantidadDias;

        $alquilerModel = new AlquilerModel();
        $alquilerModel->registrarReserva([
            'vehiculo_id'   => $vehiculo['id'],
            'cliente_id'    => $cliente['id'],
            'fecha_desde'   => $this->request->getPost('fecha_desde'),
            'cantidad_dias' => $cantidadDias,
            'monto_total'   => $montoTotal,
        ]);

        session()->setFlashdata('reserva_confirmada', [
            'vehiculo'      => $vehiculo['marca'] . ' ' . $vehiculo['modelo'],
            'fecha_desde'   => $this->request->getPost('fecha_desde'),
            'cantidad_dias' => $cantidadDias,
            'monto_total'   => $montoTotal,
        ]);

        return redirect()->to(base_url('reservas/confirmacion'));
    }

    public function confirmacion()
    {
        $reserva = session()->getFlashdata('reserva_confirmada');

        if (!$reserva) {
            return redirect()->to(base_url('vehiculos'));
        }

        return view('layout/nav') . view('cliente/reservas/confirmacion', ['reserva' => $reserva]) . view('layout/footer');
    }

    // ── ADMIN ────────────────────────────────────────────────

    public function adminIndex()
    {
        $model = new AlquilerModel();

        $alquileres = $model->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, v.marca, v.modelo')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.activo', 1)
            ->orderBy('a.id', 'DESC')
            ->get()->getResultArray();

        return view('layout/nav') . view('admin/alquileres/lista', ['alquileres' => $alquileres]) . view('layout/footer');
    }

    public function confirmarAlquiler(int $id)
    {
        $model = new AlquilerModel();

        if (!$model->confirmarAlquiler($id)) {
            return redirect()->to(base_url('admin/alquileres'))
                ->with('error', 'No se pudo confirmar el alquiler.');
        }

        return redirect()->to(base_url('admin/alquileres'))
            ->with('exito', 'Alquiler confirmado correctamente.');
    }

    public function rechazarAlquiler(int $id)
    {
        $model    = new AlquilerModel();
        $alquiler = $model->find($id);

        if (!$alquiler) {
            return redirect()->to(base_url('admin/alquileres'))
                ->with('error', 'Alquiler no encontrado.');
        }

        $model->update($id, [
            'estado' => 'Rechazado',
            'activo' => 1,
        ]);

        $vehiculoModel = new VehiculoModel();
        $vehiculoModel->marcarComoDisponible($alquiler['vehiculo_id']);

        return redirect()->to(base_url('admin/alquileres'))
            ->with('exito', 'Reserva rechazada correctamente.');
    }

    public function registrarDevolucion(int $id)
    {
        $model = new AlquilerModel();

        if (!$model->registrarDevolucion($id)) {
            return redirect()->to(base_url('admin/alquileres'))
                ->with('error', 'No se pudo registrar la devolución.');
        }

        return redirect()->to(base_url('admin/alquileres'))
            ->with('exito', 'Devolución registrada correctamente.');
    }
}