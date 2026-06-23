<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MyCarSeeder extends Seeder
{
    public function run()
    {
        // --- Vehiculos de ejemplo ---
        $vehiculos = [
            [
                'marca' => 'Toyota', 'modelo' => 'Corolla', 'categoria' => 'Auto', 'anio' => 2022,
                'plazas' => 5, 'motor' => '1.8 Nafta', 'kilometraje' => 32000,
                'precio_dia' => 18000.00, 'activo' => 1, 'disponible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'marca' => 'Volkswagen', 'modelo' => 'Gol Trend', 'categoria' => 'Auto', 'anio' => 2020,
                'plazas' => 5, 'motor' => '1.6 Nafta', 'kilometraje' => 58000,
                'precio_dia' => 12000.00, 'activo' => 1, 'disponible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'marca' => 'Ford', 'modelo' => 'Ranger','categoria' => 'Camioneta', 'anio' => 2023,
                'plazas' => 5, 'motor' => '3.2 Diesel', 'kilometraje' => 15000,
                'precio_dia' => 35000.00, 'activo' => 1, 'disponible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('vehiculos')->insertBatch($vehiculos);

        // --- Cliente de ejemplo ---
        $this->db->table('clientes')->insert([
            'nombre'     => 'Ana',
            'apellido'   => 'Gomez',
            'direccion'  => 'San Luis 123',
            'telefono'   => '266-1234567',
            'fecha_alta' => date('Y-m-d'),
            'activo'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $idCliente = $this->db->insertID();

        // --- Usuario administrador ---
        // Password en texto plano solo aca, en el seeder, para que sepas con que loguear.
        // Se guarda hasheado, jamas en texto plano.
        $this->db->table('usuarios')->insert([
            'nombre'   => 'Administrador',
            'email'    => 'admin@mycar.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'rol'      => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // --- Usuario cliente (vinculado al cliente Ana) ---
        $usuarioId = null;
    $this->db->table('usuarios')->insert([
        'nombre'   => 'Ana',
        'email'    => 'ana@mycar.com',
        'password' => password_hash('ana123', PASSWORD_DEFAULT),
        'rol'      => 'cliente',
        'created_at' => date('Y-m-d H:i:s'),
    ]);
    $usuarioId = $this->db->insertID();

    // Actualizar el cliente con el usuario_id
    $this->db->table('clientes')->where('id', $idCliente)->update(['usuario_id' => $usuarioId]);
    }
}