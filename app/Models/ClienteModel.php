<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'nombre', 'apellido', 'direccion', 'telefono',
        'fecha_alta', 'activo',
    ];

    // Reglas de validacion: CI4 las chequea solas al usar insert()/update()
    // si llamas a $model->insert($data) (no insert($data, false))
    protected $validationRules = [
        'nombre'     => 'required|min_length[2]|max_length[100]',
        'apellido'   => 'required|min_length[2]|max_length[100]',
        'telefono'   => 'permit_empty|max_length[30]',
        'direccion'  => 'permit_empty|max_length[200]',
        'fecha_alta' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'nombre'   => ['required' => 'El nombre es obligatorio'],
        'apellido' => ['required' => 'El apellido es obligatorio'],
    ];

    /**
     * Solo clientes activos (para combos, listados, etc.)
     */
    public function activos()
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Baja logica: no borra la fila, solo la marca como inactiva.
     * Asi se conserva el historial de alquileres.
     */
    public function darDeBaja(int $idCliente): bool
    {
        return $this->update($idCliente, ['activo' => 0]);
    }

    public function reactivar(int $idCliente): bool
    {
        return $this->update($idCliente, ['activo' => 1]);
    }
}
