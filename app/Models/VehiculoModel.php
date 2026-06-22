<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
<<<<<<< HEAD
    protected $table         = 'vehiculos';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['categoria', 'marca', 'modelo', 'anio', 'plazas', 'motor', 
                                'kilometraje', 'precio_dia', 'descripcion', 'imagen', 'activo'];

    // Solo los vehículos activos (para la vista pública)
    public function getDisponibles()
    {
        return $this->where('activo', 1)->findAll();
    }

    // Filtra por categoría (Auto, Camioneta, SUV, etc.)
    public function getPorCategoria(string $categoria)
    {
        return $this->where('activo', 1)
                    ->where('categoria', $categoria)
                    ->findAll();
    }

    // Baja lógica
    public function bajaLogica(int $id)
    {
        return $this->update($id, ['activo' => 0]);
    }
}
=======
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
>>>>>>> 8c3e1c85c4cce36eb3d1d9943334147bcee5af82
