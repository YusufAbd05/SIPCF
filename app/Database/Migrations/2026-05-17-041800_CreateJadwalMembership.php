<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalMembership extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_sewa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'sesi_ke' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],
            'tanggal_main' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'status_sesi' => [
                'type'       => 'ENUM',
                'constraint' => ['Terjadwal', 'Selesai', 'Dibatalkan'],
                'default'    => 'Terjadwal',
            ],
        ]);

        $this->forge->addKey('id_jadwal', true);
        $this->forge->addForeignKey('id_sewa', 't_sewa_lapangan', 'id_sewa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_jadwal_membership');
    }

    public function down()
    {
        $this->forge->dropTable('t_jadwal_membership');
    }
}
