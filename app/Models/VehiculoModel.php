<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculoModel extends Model
{
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