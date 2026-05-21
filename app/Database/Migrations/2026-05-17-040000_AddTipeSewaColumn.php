<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipeSewaColumn extends Migration
{
    public function up()
    {
        // 1. Add tipe_sewa column to t_sewa_lapangan
        $this->forge->addColumn('t_sewa_lapangan', [
            'tipe_sewa' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => '1x_main',
                'after'      => 'tipe_pesanan',
            ],
        ]);

        // 2. Fix status_pesanan ENUM — add 'Menunggu' value
        //    Using raw SQL since forge doesn't support ENUM modification cleanly
        $this->db->query("ALTER TABLE t_sewa_lapangan MODIFY COLUMN status_pesanan ENUM('Menunggu','Menunggu Pembayaran','Menunggu Verifikasi','Dikonfirmasi','Ditolak','Selesai','Dibatalkan') DEFAULT 'Menunggu Pembayaran'");
    }

    public function down()
    {
        $this->forge->dropColumn('t_sewa_lapangan', 'tipe_sewa');

        // Revert ENUM
        $this->db->query("ALTER TABLE t_sewa_lapangan MODIFY COLUMN status_pesanan ENUM('Menunggu Pembayaran','Menunggu Verifikasi','Dikonfirmasi','Ditolak','Selesai','Dibatalkan') DEFAULT 'Menunggu Pembayaran'");
    }
}
