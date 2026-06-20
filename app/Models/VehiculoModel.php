<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
    protected $table            = 'vehiculos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'marca', 'modelo', 'anio', 'plazas', 'motor',
        'kilometraje', 'precio_dia', 'activo', 'disponible',
    ];

    protected $validationRules = [
        'marca'       => 'required|max_length[60]',
        'modelo'      => 'required|max_length[60]',
        'anio'        => 'required|integer|greater_than[1980]',
        'plazas'      => 'required|integer|greater_than[0]|less_than[20]',
        'kilometraje' => 'permit_empty|integer|greater_than_equal_to[0]',
        'precio_dia'  => 'required|decimal|greater_than[0]',
    ];

    protected $validationMessages = [
        'marca'      => ['required' => 'La marca es obligatoria'],
        'modelo'     => ['required' => 'El modelo es obligatorio'],
        'precio_dia' => ['greater_than' => 'El precio por dia debe ser mayor a 0'],
    ];

    /**
     * Lista para la vista publica: vehiculos activos y libres ahora mismo.
     * Replica el listado de la app Android.
     */
    public function disponiblesParaAlquilar()
    {
        return $this->where('activo', 1)
                    ->where('disponible', 1)
                    ->findAll();
    }

    public function marcarComoAlquilado(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['disponible' => 0]);
    }

    public function marcarComoDisponible(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['disponible' => 1]);
    }

    /** Baja logica del vehiculo, conserva historial de alquileres */
    public function darDeBaja(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['activo' => 0]);
    }
}
