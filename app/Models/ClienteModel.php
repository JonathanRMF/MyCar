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
        'usuario_id',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'fecha_alta',
        'activo'
    ];

    protected $validationRules = [
        'nombre'     => 'required|min_length[2]|max_length[100]',
        'apellido'   => 'required|min_length[2]|max_length[100]',
        'fecha_alta' => 'required|valid_date',
    ];

    public function findByUsuarioId(int $usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }

    public function activos()
    {
        return $this->where('activo', 1)->findAll();
    }

    public function bajaLogica(int $id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    public function darDeBaja(int $idCliente): bool
    {
        return $this->update($idCliente, ['activo' => 0]);
    }

    public function reactivar(int $idCliente): bool
    {
        return $this->update($idCliente, ['activo' => 1]);
    }
}