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
            'categoria' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
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
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'imagen' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'disponible' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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