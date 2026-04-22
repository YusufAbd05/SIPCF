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
            'nama_lapangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'spesifikasi_lapang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_lapang' => [
                'type' => 'ENUM',
                'constraint' => ['Tersedia', 'Perbaikan'],
                'default' => 'Tersedia',
            ],
            'jam_buka_weekday' => [
                'type' => 'TIME',
            ],
            'jam_tutup_weekday' => [
                'type' => 'TIME',
            ],
            'jam_buka_weekend' => [
                'type' => 'TIME',
            ],
            'jam_tutup_weekend' => [
                'type' => 'TIME',
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
