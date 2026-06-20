<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlquileresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_vehiculo' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_cliente' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'fecha_desde' => [
                'type' => 'DATE',
            ],
            'cantidad_dias' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'fecha_devolucion_real' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'estado' => [
                // reservado: el cliente pidio, el admin no confirmo todavia
                // alquilado: el admin confirmo, el vehiculo esta en uso
                // finalizado: ya se devolvio el vehiculo
                'type'       => 'ENUM',
                'constraint' => ['reservado', 'alquilado', 'finalizado'],
                'default'    => 'reservado',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_vehiculo', 'vehiculos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('id_cliente', 'clientes', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('alquileres');
    }

    public function down()
    {
        $this->forge->dropTable('alquileres');
    }
}
