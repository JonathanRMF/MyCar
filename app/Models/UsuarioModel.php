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

    protected $allowedFields = ['email', 'password', 'rol', 'id_cliente'];

    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'rol'      => 'required|in_list[admin,cliente]',
    ];

    /**
     * Crea un usuario con password hasheado. Usar esto en vez de
     * insert() directo para no guardar nunca texto plano.
     */
    public function registrar(string $email, string $password, string $rol = 'cliente', ?int $idCliente = null): int|false
    {
        return $this->insert([
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'rol'        => $rol,
            'id_cliente' => $idCliente,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Verifica credenciales. Devuelve el usuario (sin password) si son
     * correctas, o null si no.
     */
    public function verificarLogin(string $email, string $password): ?array
    {
        $usuario = $this->where('email', $email)->first();

        if (! $usuario || ! password_verify($password, $usuario['password'])) {
            return null;
        }

        unset($usuario['password']);
        return $usuario;
    }
}
