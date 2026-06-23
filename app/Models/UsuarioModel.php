<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'activo', 'created_at'];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}