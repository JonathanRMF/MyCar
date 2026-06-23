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
        'categoria',
        'marca',
        'modelo',
        'anio',
        'plazas',
        'motor',
        'kilometraje',
        'precio_dia',
        'descripcion',
        'imagen',
        'activo',
        'disponible'
    ];

    protected $validationRules = [
        'marca'       => 'required|max_length[60]',
        'modelo'      => 'required|max_length[60]',
        'anio'        => 'required|integer',
        'plazas'      => 'required|integer|greater_than[0]',
        'kilometraje' => 'permit_empty|integer|greater_than_equal_to[0]',
        'precio_dia'  => 'required|decimal|greater_than[0]',
    ];

    public function getDisponibles()
    {
        return $this->where('activo', 1)->findAll();
    }

    public function disponiblesParaAlquilar()
    {
        return $this->where('activo', 1)
                    ->where('disponible', 1)
                    ->findAll();
    }

    public function getPorCategoria(string $categoria)
    {
        return $this->where('activo', 1)
                    ->where('categoria', $categoria)
                    ->findAll();
    }

    public function bajaLogica(int $id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    public function darDeBaja(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['activo' => 0]);
    }

    public function marcarComoAlquilado(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['disponible' => 0]);
    }

    public function marcarComoDisponible(int $idVehiculo): bool
    {
        return $this->update($idVehiculo, ['disponible' => 1]);
    }

    // NUEVO MÉTODO - Obtener categorías únicas
    public function getCategorias()
    {
        return $this->select('categoria')
                    ->distinct()
                    ->orderBy('categoria', 'ASC')
                    ->findColumn('categoria') ?: [];
    }
}