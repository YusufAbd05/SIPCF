<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TLapangTarif extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tarif' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_lapang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_tarif' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'hari' => [
                'type' => 'ENUM',
                'constraint' => ['Weekday', 'Weekend', 'Libur Nasional'],
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'harga_umum' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'harga_member' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('id_tarif', true);
        $this->forge->addForeignKey('id_lapang', 't_lapang', 'id_lapang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_lapang_tarif');
    }

    public function down()
    {
        $this->forge->dropTable('t_lapang_tarif');
    }
}
