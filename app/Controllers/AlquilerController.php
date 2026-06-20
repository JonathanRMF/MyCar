<?php

namespace App\Controllers;

use App\Models\AlquilerModel;
use App\Models\VehiculoModel;
use App\Models\ClienteModel;

class AlquilerController extends BaseController
{
    // ── CLIENTE ──────────────────────────────────────────────

    // Muestra el formulario de reserva para un vehículo
    public function nuevaReserva(int $vehiculoId)
    {
        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($vehiculoId);

        if (!$vehiculo || !$vehiculo['activo']) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no disponible.');
        }

        return view('layout/nav') . view('cliente/reservas/nueva', ['vehiculo' => $vehiculo]) . view('layout/footer');
    }

    // Guarda la reserva en la BD
    public function guardarReserva()
    {
        $rules = [
            'vehiculo_id'   => 'required|numeric',
            'fecha_desde'   => 'required|valid_date',
            'cantidad_dias' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errores', $this->validator->getErrors())
                ->withInput();
        }

        // Buscamos el cliente vinculado al usuario logueado
        $clienteModel = new ClienteModel();
        $cliente      = $clienteModel->findByUsuarioId(session()->get('usuario_id'));

        if (!$cliente) {
            return redirect()->to('/vehiculos')->with('error', 'No se encontró tu perfil de cliente.');
        }

        // Calculamos el monto en el servidor (nunca confiar en el form)
        $vehiculoModel = new VehiculoModel();
        $vehiculo      = $vehiculoModel->find($this->request->getPost('vehiculo_id'));
        $cantidadDias  = (int) $this->request->getPost('cantidad_dias');
        $montoTotal    = $vehiculo['precio_dia'] * $cantidadDias;

        $alquilerModel = new AlquilerModel();
        $alquilerModel->insert([
            'vehiculo_id'   => $vehiculo['id'],
            'cliente_id'    => $cliente['id'],
            'fecha_desde'   => $this->request->getPost('fecha_desde'),
            'cantidad_dias' => $cantidadDias,
            'monto_total'   => $montoTotal,
            'devuelto'      => 0,
            'activo'        => 1,
        ]);

        // Guardamos el resumen en sesión flash para mostrarlo en la confirmación
        session()->setFlashdata('reserva_confirmada', [
            'vehiculo'      => $vehiculo['marca'] . ' ' . $vehiculo['modelo'],
            'fecha_desde'   => $this->request->getPost('fecha_desde'),
            'cantidad_dias' => $cantidadDias,
            'monto_total'   => $montoTotal,
        ]);

        return redirect()->to('/reservas/confirmacion');
    }

    // Pantalla de confirmación después de reservar
    public function confirmacion()
    {
        $reserva = session()->getFlashdata('reserva_confirmada');

        if (!$reserva) {
            return redirect()->to('/vehiculos');
        }

        return view('layout/nav') . view('cliente/reservas/confirmacion', ['reserva' => $reserva]) . view('layout/footer');
    }

    // ── ADMIN ────────────────────────────────────────────────

    // Lista todos los alquileres/reservas
    public function adminIndex()
    {
        $model = new AlquilerModel();

        // Join manual para traer datos de cliente y vehículo
        $alquileres = $model->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, v.marca, v.modelo')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.activo', 1)
            ->orderBy('a.id', 'DESC')
            ->get()->getResultArray();

        return view('layout/nav') . view('admin/alquileres/lista', ['alquileres' => $alquileres]) . view('layout/footer');
    }

    // Admin confirma una reserva como alquiler activo
    public function confirmarAlquiler(int $id)
    {
        $model = new AlquilerModel();
        $model->update($id, ['devuelto' => 0]); // ya estaba en 0, pero marca que fue revisado
        return redirect()->to('/admin/alquileres')
            ->with('exito', 'Alquiler confirmado.');
    }

    // Registrar devolución del vehículo
    public function registrarDevolucion(int $id)
    {
        $model = new AlquilerModel();
        $model->registrarDevolucion($id);
        return redirect()->to('/admin/alquileres')
            ->with('exito', 'Devolución registrada correctamente.');
    }
}