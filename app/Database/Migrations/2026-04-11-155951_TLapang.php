<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TLapang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lapang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_lapang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jam_operasional' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'harga_per_jam' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Dapat Digunakan', 'Sedang Perbaikan'],
                'default' => 'Dapat Digunakan',
            ],
        ]);

        $this->forge->addKey('id_lapang', true);
        $this->forge->createTable('t_lapang');
    }

    public function down()
    {
        $this->forge->dropTable('t_lapang');
    }
}
