<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table         = 'alquileres';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['vehiculo_id', 'cliente_id', 'fecha_desde', 
                                'cantidad_dias', 'monto_total', 'devuelto', 'activo'];

    // Reporte 1: todos los alquileres de un vehículo con datos del cliente
    public function getPorVehiculo(int $vehiculoId)
    {
        return $this->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, c.telefono, v.marca, v.modelo')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.vehiculo_id', $vehiculoId)
            ->where('a.activo', 1)
            ->get()->getResultArray();
    }

    // Reporte 2: todos los alquileres de un cliente con datos del vehículo
    public function getPorCliente(int $clienteId)
    {
        return $this->db->table('alquileres a')
            ->select('a.*, v.marca, v.modelo, v.categoria, v.precio_dia')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.cliente_id', $clienteId)
            ->where('a.activo', 1)
            ->get()->getResultArray();
    }

    // Reporte 3: vehículos actualmente alquilados (no devueltos)
    public function getActivos()
    {
        return $this->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, c.telefono, v.marca, v.modelo, v.categoria')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.devuelto', 0)
            ->where('a.activo', 1)
            ->get()->getResultArray();
    }

    // Marcar como devuelto
    public function registrarDevolucion(int $id)
    {
        return $this->update($id, ['devuelto' => 1]);
    }
}