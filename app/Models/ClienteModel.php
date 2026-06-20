<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table         = 'clientes';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['usuario_id', 'apellido', 'nombre', 'direccion', 'telefono', 'fecha_alta', 'activo'];

    // Busca el cliente vinculado a un usuario (útil para saber quién es el cliente logueado)
    public function findByUsuarioId(int $usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }

    // Baja lógica — no borra, solo marca activo=0
    public function bajaLogica(int $id)
    {
        return $this->update($id, ['activo' => 0]);
    }
}