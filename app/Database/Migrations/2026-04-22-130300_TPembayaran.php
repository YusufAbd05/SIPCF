<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TPembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembayaran' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_sewa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jenis_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['DP', 'Pelunasan', 'Full'],
            ],
            'jumlah_bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0,
            ],
            'metode' => [
                'type' => 'ENUM',
                'constraint' => ['Transfer Bank', 'E-Wallet', 'Cash'],
            ],
            'url_bukti_bayar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Sukses', 'Ditolak'],
                'default' => 'Pending',
            ],
            'waktu_pembayaran' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_pembayaran', true);
        $this->forge->addForeignKey('id_sewa', 't_sewa_lapangan', 'id_sewa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('t_pembayaran');
    }
}
