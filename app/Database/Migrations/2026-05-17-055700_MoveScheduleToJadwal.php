<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MoveScheduleToJadwal extends Migration
{
    public function up()
    {
        // ═══════════════════════════════════════════════
        //  1. Migrate existing Per Jam bookings to t_jadwal
        //     (bookings that have tanggal_main but no t_jadwal record)
        // ═══════════════════════════════════════════════
        $db = \Config\Database::connect();

        $orphanBookings = $db->query("
            SELECT s.id_sewa, s.tanggal_main, s.jam_mulai, s.jam_selesai
            FROM t_sewa_lapangan s
            LEFT JOIN t_jadwal j ON j.id_sewa = s.id_sewa
            WHERE j.id_jadwal IS NULL
              AND s.tanggal_main IS NOT NULL
        ")->getResultArray();

        foreach ($orphanBookings as $b) {
            $db->table('t_jadwal')->insert([
                'id_sewa'      => $b['id_sewa'],
                'sesi_ke'      => 1,
                'tanggal_main' => $b['tanggal_main'],
                'jam_mulai'    => $b['jam_mulai'],
                'jam_selesai'  => $b['jam_selesai'],
                'status_sesi'  => 'Terjadwal',
            ]);
        }

        // ═══════════════════════════════════════════════
        //  2. Drop indexes that reference the columns
        // ═══════════════════════════════════════════════
        try { $db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_tanggal_main"); } catch (\Exception $e) {}
        try { $db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_slot_check"); } catch (\Exception $e) {}

        // ═══════════════════════════════════════════════
        //  3. Drop columns from t_sewa_lapangan
        // ═══════════════════════════════════════════════
        $db->query("ALTER TABLE t_sewa_lapangan DROP COLUMN tanggal_main");
        $db->query("ALTER TABLE t_sewa_lapangan DROP COLUMN jam_mulai");
        $db->query("ALTER TABLE t_sewa_lapangan DROP COLUMN jam_selesai");
    }

    public function down()
    {
        $db = \Config\Database::connect();

        // Re-add columns
        $db->query("ALTER TABLE t_sewa_lapangan ADD COLUMN tanggal_main DATE NOT NULL AFTER tipe_sewa");
        $db->query("ALTER TABLE t_sewa_lapangan ADD COLUMN jam_mulai TIME NOT NULL AFTER tanggal_main");
        $db->query("ALTER TABLE t_sewa_lapangan ADD COLUMN jam_selesai TIME NOT NULL AFTER jam_mulai");

        // Re-add indexes
        $db->query("ALTER TABLE t_sewa_lapangan ADD INDEX idx_tanggal_main (tanggal_main)");

        // Restore data from t_jadwal sesi_ke=1
        $db->query("
            UPDATE t_sewa_lapangan s
            JOIN t_jadwal j ON j.id_sewa = s.id_sewa AND j.sesi_ke = 1
            SET s.tanggal_main = j.tanggal_main,
                s.jam_mulai = j.jam_mulai,
                s.jam_selesai = j.jam_selesai
        ");
    }
}
