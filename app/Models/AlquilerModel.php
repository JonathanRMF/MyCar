<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'vehiculo_id',
        'cliente_id',
        'fecha_desde',
        'cantidad_dias',
        'monto_total',
        'devuelto',
        'activo',
        'estado'
    ];

    protected $validationRules = [
        'vehiculo_id'   => 'required|integer',
        'cliente_id'    => 'required|integer',
        'fecha_desde'   => 'required|valid_date',
        'cantidad_dias' => 'required|integer|greater_than[0]',
    ];

    public function registrarReserva(array $data)
    {
        $data['estado']   = 'reservado';
        $data['devuelto'] = 0;
        $data['activo']   = 1;

        return $this->insert($data);
    }

    public function confirmarAlquiler(int $idAlquiler): bool
    {
        $alquiler = $this->find($idAlquiler);

        if (!$alquiler) {
            return false;
        }

        $this->update($idAlquiler, [
            'estado'   => 'alquilado',
            'devuelto' => 0
        ]);

        $vehiculoModel = new VehiculoModel();
        $vehiculoModel->marcarComoAlquilado($alquiler['vehiculo_id']);

        return true;
    }

    public function registrarDevolucion(int $idAlquiler): bool
    {
        $alquiler = $this->find($idAlquiler);

        if (!$alquiler) {
            return false;
        }

        $this->update($idAlquiler, [
            'estado'   => 'finalizado',
            'devuelto' => 1
        ]);

        $vehiculoModel = new VehiculoModel();
        $vehiculoModel->marcarComoDisponible($alquiler['vehiculo_id']);

        return true;
    }

    public function reservasPendientes()
    {
        return $this->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, v.marca, v.modelo')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.estado', 'reservado')
            ->where('a.activo', 1)
            ->get()
            ->getResultArray();
    }

    public function getActivos()
    {
        return $this->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, c.telefono, v.marca, v.modelo, v.categoria')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.estado', 'alquilado')
            ->where('a.activo', 1)
            ->get()
            ->getResultArray();
    }

    public function getPorVehiculo(int $vehiculoId)
    {
        return $this->db->table('alquileres a')
            ->select('a.*, c.nombre, c.apellido, c.telefono')
            ->join('clientes c', 'c.id = a.cliente_id')
            ->where('a.vehiculo_id', $vehiculoId)
            ->where('a.activo', 1)
            ->orderBy('a.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPorCliente(int $clienteId)
    {
        return $this->db->table('alquileres a')
            ->select('a.*, v.marca, v.modelo, v.categoria')
            ->join('vehiculos v', 'v.id = a.vehiculo_id')
            ->where('a.cliente_id', $clienteId)
            ->where('a.activo', 1)
            ->orderBy('a.id', 'DESC')
            ->get()
            ->getResultArray();
    }
}