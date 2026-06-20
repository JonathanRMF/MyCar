<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'activo'];

    // Busca un usuario por su email (para el login)
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}