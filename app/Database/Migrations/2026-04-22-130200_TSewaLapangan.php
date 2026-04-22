<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TSewaLapangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sewa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_sewa' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_lapang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_penyewa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_hp_penyewa' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tipe_pesanan' => [
                'type' => 'ENUM',
                'constraint' => ['Online', 'Walk-in'],
                'default' => 'Online',
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
            'durasi_jam' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'total_bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'status_pesanan' => [
                'type' => 'ENUM',
                'constraint' => ['Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikonfirmasi', 'Ditolak', 'Selesai', 'Dibatalkan'],
                'default' => 'Menunggu Pembayaran',
            ],
            'alasan_penolakan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_sewa', true);
        $this->forge->addForeignKey('id_user', 't_user', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_lapang', 't_lapang', 'id_lapang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_sewa_lapangan');
    }

    public function down()
    {
        $this->forge->dropTable('t_sewa_lapangan');
    }
}
