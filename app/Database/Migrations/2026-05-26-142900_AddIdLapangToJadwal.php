<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdLapangToJadwal extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // 1. Add id_lapang column to t_jadwal
        $db->query("ALTER TABLE t_jadwal ADD COLUMN id_lapang INT UNSIGNED NOT NULL AFTER id_sewa");

        // 2. Migrate: copy id_lapang from t_sewa_lapangan to all related t_jadwal rows
        $db->query("
            UPDATE t_jadwal j
            JOIN t_sewa_lapangan s ON s.id_sewa = j.id_sewa
            SET j.id_lapang = s.id_lapang
        ");

        // 3. Add index for performance
        $db->query("ALTER TABLE t_jadwal ADD INDEX idx_jadwal_lapang (id_lapang)");
    }

    public function down()
    {
        $db = \Config\Database::connect();

        try { $db->query("ALTER TABLE t_jadwal DROP INDEX idx_jadwal_lapang"); } catch (\Exception $e) {}
        $db->query("ALTER TABLE t_jadwal DROP COLUMN id_lapang");
    }
}
