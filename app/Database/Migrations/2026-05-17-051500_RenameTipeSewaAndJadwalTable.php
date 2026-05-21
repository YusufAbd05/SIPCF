<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameTipeSewaAndJadwalTable extends Migration
{
    public function up()
    {
        // 1. Change tipe_sewa from VARCHAR to ENUM('Per Jam','Harian','Membership')
        $this->db->query("ALTER TABLE t_sewa_lapangan MODIFY COLUMN tipe_sewa ENUM('Per Jam','Harian','Membership') DEFAULT 'Per Jam'");

        // 2. Rename t_jadwal_membership → t_jadwal
        $this->forge->renameTable('t_jadwal_membership', 't_jadwal');
    }

    public function down()
    {
        // Revert table name
        $this->forge->renameTable('t_jadwal', 't_jadwal_membership');

        // Revert column
        $this->db->query("ALTER TABLE t_sewa_lapangan MODIFY COLUMN tipe_sewa VARCHAR(30) DEFAULT '1x_main'");
    }
}
