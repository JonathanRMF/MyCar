<?php

namespace App\Services;

use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class UsuarioService
{
    protected UsuarioModel $usuarioModel;
    protected ClienteModel $clienteModel;
    protected ?array $errors = null;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->clienteModel = new ClienteModel();
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->usuarioModel->findByEmail($email);
    }

    public function login(string $email, string $password): ?array
    {
        $usuario = $this->usuarioModel->findByEmail($email);

        if (! $usuario || ! password_verify($password, $usuario['password'])) {
            $this->errors = ['login' => 'Email o contraseña incorrectos.'];
            return null;
        }

        if (array_key_exists('activo', $usuario) && intval($usuario['activo']) === 0) {
            $this->errors = ['login' => 'Tu cuenta está desactivada.'];
            return null;
        }

        $usuario['nombre'] = $this->resolveDisplayName($usuario);
        unset($usuario['password']);

        return $usuario;
    }

    public function createUser(array $data): int|false
    {
        if (! isset($data['email'], $data['password'])) {
            $this->errors = ['general' => 'Email y contraseña son obligatorios.'];
            return false;
        }

        if ($this->findByEmail($data['email'])) {
            $this->errors = ['email' => 'Ese email ya está registrado.'];
            return false;
        }

        $insertData = [
            'email'      => $data['email'],
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'rol'        => $data['rol'] ?? 'cliente',
            'id_cliente' => $data['id_cliente'] ?? null,
            'created_at' => $data['created_at'] ?? date('Y-m-d H:i:s'),
        ];

        $usuarioId = $this->usuarioModel->insert($insertData);

        if ($usuarioId === false) {
            $this->errors = $this->usuarioModel->errors() ?: ['general' => 'No se pudo crear el usuario.'];
            return false;
        }

        return $usuarioId;
    }

    public function registerClientUser(array $usuarioData, array $clienteData): int|false
    {
        if ($this->findByEmail($usuarioData['email'])) {
            $this->errors = ['email' => 'Ese email ya está registrado.'];
            return false;
        }

        $db = $this->usuarioModel->db;
        $db->transStart();

        $clienteId = $this->clienteModel->insert($clienteData);
        if ($clienteId === false) {
            $db->transRollback();
            $this->errors = $this->clienteModel->errors() ?: ['general' => 'No se pudo crear el cliente.'];
            return false;
        }

        $usuarioData['id_cliente'] = $clienteId;
        $usuarioId = $this->createUser($usuarioData);

        if ($usuarioId === false) {
            $db->transRollback();
            return false;
        }

        $db->transComplete();
        if ($db->transStatus() === false) {
            $this->errors = ['general' => 'No se pudo completar la operación.'];
            return false;
        }

        return $usuarioId;
    }

    protected function resolveDisplayName(array $usuario): string
    {
        if (! empty($usuario['nombre'])) {
            return $usuario['nombre'];
        }

        if (! empty($usuario['id_cliente'])) {
            $cliente = $this->clienteModel->find($usuario['id_cliente']);
            if ($cliente) {
                return trim($cliente['nombre'] . ' ' . $cliente['apellido']);
            }
        }

        return $usuario['email'] ?? '';
    }
}
