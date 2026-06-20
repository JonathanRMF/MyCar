<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVehiculosTable extends Migration
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
            'marca' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'modelo' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'anio' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
            ],
            'plazas' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'motor' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'kilometraje' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'precio_dia' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1, // baja logica del vehiculo
            ],
            'disponible' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1, // 0 mientras esta alquilado actualmente
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
        $this->forge->createTable('vehiculos');
    }

    public function down()
    {
        $this->forge->dropTable('vehiculos');
    }
}
