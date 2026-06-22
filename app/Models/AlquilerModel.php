<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquilerModel extends Model
{
<<<<<<< HEAD
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
=======
    protected $table            = 'alquileres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'id_vehiculo', 'id_cliente', 'fecha_desde', 'cantidad_dias',
        'fecha_devolucion_real', 'estado',
    ];

    protected $validationRules = [
        'id_vehiculo'    => 'required|integer',
        'id_cliente'     => 'required|integer',
        'fecha_desde'    => 'required|valid_date',
        'cantidad_dias'  => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'cantidad_dias' => ['greater_than' => 'La cantidad de dias debe ser mayor a 0'],
    ];

    /**
     * Un cliente envia una reserva (estado = reservado).
     * No marca el vehiculo como no-disponible todavia: eso lo hace
     * el administrador cuando la confirma como alquiler real.
     */
    public function registrarReserva(array $data): int|false
    {
        $data['estado'] = 'reservado';
        return $this->insert($data);
    }

    /**
     * El administrador confirma una reserva como alquiler.
     * A partir de aca el vehiculo pasa a no disponible.
     */
    public function confirmarAlquiler(int $idAlquiler): bool
    {
        $alquiler = $this->find($idAlquiler);
        if (! $alquiler) {
            return false;
        }

        $this->update($idAlquiler, ['estado' => 'alquilado']);

        $vehiculoModel = new VehiculoModel();
        $vehiculoModel->marcarComoAlquilado($alquiler['id_vehiculo']);

        return true;
    }

    /**
     * Registrar la devolucion del vehiculo: cierra el alquiler
     * y vuelve a poner el vehiculo como disponible.
     */
    public function registrarDevolucion(int $idAlquiler): bool
    {
        $alquiler = $this->find($idAlquiler);
        if (! $alquiler) {
            return false;
        }

        $this->update($idAlquiler, [
            'estado'                 => 'finalizado',
            'fecha_devolucion_real'  => date('Y-m-d'),
        ]);

        $vehiculoModel = new VehiculoModel();
        $vehiculoModel->marcarComoDisponible($alquiler['id_vehiculo']);

        return true;
    }

    /**
     * 2.1) Dado un vehiculo, todos los clientes que lo alquilaron,
     * con los datos de cada alquiler.
     */
    public function clientesPorVehiculo(int $idVehiculo)
    {
        return $this->select('alquileres.*, clientes.nombre, clientes.apellido,
                               clientes.telefono, clientes.direccion')
                    ->join('clientes', 'clientes.id = alquileres.id_cliente')
                    ->where('alquileres.id_vehiculo', $idVehiculo)
                    ->orderBy('alquileres.fecha_desde', 'DESC')
                    ->findAll();
    }

    /**
     * 2.2) Dado un cliente, todos los vehiculos que alquilo.
     */
    public function vehiculosPorCliente(int $idCliente)
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo,
                               vehiculos.anio, vehiculos.precio_dia')
                    ->join('vehiculos', 'vehiculos.id = alquileres.id_vehiculo')
                    ->where('alquileres.id_cliente', $idCliente)
                    ->orderBy('alquileres.fecha_desde', 'DESC')
                    ->findAll();
    }

    /**
     * 2.3) Vehiculos que estan alquilados ahora mismo, con datos del cliente.
     */
    public function alquileresActivos()
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo,
                               vehiculos.anio, clientes.nombre, clientes.apellido,
                               clientes.telefono')
                    ->join('vehiculos', 'vehiculos.id = alquileres.id_vehiculo')
                    ->join('clientes', 'clientes.id = alquileres.id_cliente')
                    ->where('alquileres.estado', 'alquilado')
                    ->orderBy('alquileres.fecha_desde', 'DESC')
                    ->findAll();
    }

    /** Reservas pendientes de confirmar por el administrador */
    public function reservasPendientes()
    {
        return $this->select('alquileres.*, vehiculos.marca, vehiculos.modelo,
                               clientes.nombre, clientes.apellido')
                    ->join('vehiculos', 'vehiculos.id = alquileres.id_vehiculo')
                    ->join('clientes', 'clientes.id = alquileres.id_cliente')
                    ->where('alquileres.estado', 'reservado')
                    ->orderBy('alquileres.fecha_desde', 'ASC')
                    ->findAll();
    }
}
>>>>>>> 8c3e1c85c4cce36eb3d1d9943334147bcee5af82
