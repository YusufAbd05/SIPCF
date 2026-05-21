<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixDatabaseOverall extends Migration
{
    /**
     * Helper: Check if a column exists in a table.
     */
    private function columnExists(string $table, string $column): bool
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?",
            [$table, $column]
        )->getRow();
        return ($result->cnt ?? 0) > 0;
    }

    /**
     * Helper: Check if an index exists on a table.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $result = $this->db->query("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName])->getResultArray();
        return !empty($result);
    }

    /**
     * Helper: Check if a FK constraint exists.
     */
    private function fkExists(string $table, string $constraintName): bool
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
            [$table, $constraintName]
        )->getRow();
        return ($result->cnt ?? 0) > 0;
    }

    public function up()
    {
        // ═══════════════════════════════════════════════
        //  1. t_user — Add UNIQUE on email, add timestamps
        // ═══════════════════════════════════════════════
        if (!$this->columnExists('t_user', 'created_at')) {
            $this->db->query("ALTER TABLE t_user ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        }
        if (!$this->columnExists('t_user', 'updated_at')) {
            $this->db->query("ALTER TABLE t_user ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
        }
        if (!$this->indexExists('t_user', 'idx_user_email')) {
            // Check if any unique index on email already exists
            $existing = $this->db->query("SHOW INDEX FROM t_user WHERE Column_name = 'email' AND Non_unique = 0")->getResultArray();
            if (empty($existing)) {
                $this->db->query("ALTER TABLE t_user ADD UNIQUE INDEX idx_user_email (email)");
            }
        }

        // ═══════════════════════════════════════════════
        //  2. t_lapang — Add timestamps
        // ═══════════════════════════════════════════════
        if (!$this->columnExists('t_lapang', 'created_at')) {
            $this->db->query("ALTER TABLE t_lapang ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        }
        if (!$this->columnExists('t_lapang', 'updated_at')) {
            $this->db->query("ALTER TABLE t_lapang ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
        }

        // ═══════════════════════════════════════════════
        //  3. t_sewa_lapangan — UNIQUE kode_sewa, updated_at, indexes
        // ═══════════════════════════════════════════════
        if (!$this->columnExists('t_sewa_lapangan', 'updated_at')) {
            $this->db->query("ALTER TABLE t_sewa_lapangan ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
        }

        // Ensure created_at defaults properly
        $this->db->query("ALTER TABLE t_sewa_lapangan MODIFY COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");

        // UNIQUE on kode_sewa
        if (!$this->indexExists('t_sewa_lapangan', 'idx_kode_sewa')) {
            $existing = $this->db->query("SHOW INDEX FROM t_sewa_lapangan WHERE Column_name = 'kode_sewa' AND Non_unique = 0")->getResultArray();
            if (empty($existing)) {
                $this->db->query("ALTER TABLE t_sewa_lapangan ADD UNIQUE INDEX idx_kode_sewa (kode_sewa)");
            }
        }

        // Index on tanggal_main (frequently queried)
        if (!$this->indexExists('t_sewa_lapangan', 'idx_tanggal_main')) {
            $this->db->query("ALTER TABLE t_sewa_lapangan ADD INDEX idx_tanggal_main (tanggal_main)");
        }

        // Index on status_pesanan (used in WHERE filters)
        if (!$this->indexExists('t_sewa_lapangan', 'idx_status_pesanan')) {
            $this->db->query("ALTER TABLE t_sewa_lapangan ADD INDEX idx_status_pesanan (status_pesanan)");
        }

        // Composite index for slot availability check
        if (!$this->indexExists('t_sewa_lapangan', 'idx_slot_check')) {
            $this->db->query("ALTER TABLE t_sewa_lapangan ADD INDEX idx_slot_check (id_lapang, tanggal_main, status_pesanan)");
        }

        // ═══════════════════════════════════════════════
        //  4. t_jadwal — Index tanggal_main, fix old FK name
        // ═══════════════════════════════════════════════
        if (!$this->indexExists('t_jadwal', 'idx_jadwal_tanggal')) {
            $this->db->query("ALTER TABLE t_jadwal ADD INDEX idx_jadwal_tanggal (tanggal_main)");
        }

        // Rename old FK from t_jadwal_membership_* to t_jadwal_*
        if ($this->fkExists('t_jadwal', 't_jadwal_membership_id_sewa_foreign')) {
            $this->db->query("ALTER TABLE t_jadwal DROP FOREIGN KEY t_jadwal_membership_id_sewa_foreign");
            $this->db->query("ALTER TABLE t_jadwal ADD CONSTRAINT t_jadwal_id_sewa_foreign FOREIGN KEY (id_sewa) REFERENCES t_sewa_lapangan(id_sewa) ON DELETE CASCADE ON UPDATE CASCADE");
        }

        // ═══════════════════════════════════════════════
        //  5. t_pembayaran — Add created_at, add ON DELETE CASCADE
        // ═══════════════════════════════════════════════
        if (!$this->columnExists('t_pembayaran', 'created_at')) {
            $this->db->query("ALTER TABLE t_pembayaran ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        }

        // Update FK to CASCADE on delete (if a booking is deleted, payments should too)
        if ($this->fkExists('t_pembayaran', 't_pembayaran_id_sewa_foreign')) {
            $this->db->query("ALTER TABLE t_pembayaran DROP FOREIGN KEY t_pembayaran_id_sewa_foreign");
            $this->db->query("ALTER TABLE t_pembayaran ADD CONSTRAINT t_pembayaran_id_sewa_foreign FOREIGN KEY (id_sewa) REFERENCES t_sewa_lapangan(id_sewa) ON DELETE CASCADE ON UPDATE CASCADE");
        }
    }

    public function down()
    {
        // Revert timestamp columns
        if ($this->columnExists('t_user', 'created_at')) {
            $this->db->query("ALTER TABLE t_user DROP COLUMN created_at");
        }
        if ($this->columnExists('t_user', 'updated_at')) {
            $this->db->query("ALTER TABLE t_user DROP COLUMN updated_at");
        }
        if ($this->columnExists('t_lapang', 'created_at')) {
            $this->db->query("ALTER TABLE t_lapang DROP COLUMN created_at");
        }
        if ($this->columnExists('t_lapang', 'updated_at')) {
            $this->db->query("ALTER TABLE t_lapang DROP COLUMN updated_at");
        }
        if ($this->columnExists('t_sewa_lapangan', 'updated_at')) {
            $this->db->query("ALTER TABLE t_sewa_lapangan DROP COLUMN updated_at");
        }
        if ($this->columnExists('t_pembayaran', 'created_at')) {
            $this->db->query("ALTER TABLE t_pembayaran DROP COLUMN created_at");
        }

        // Revert indexes
        try { $this->db->query("ALTER TABLE t_user DROP INDEX idx_user_email"); } catch (\Exception $e) {}
        try { $this->db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_kode_sewa"); } catch (\Exception $e) {}
        try { $this->db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_tanggal_main"); } catch (\Exception $e) {}
        try { $this->db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_status_pesanan"); } catch (\Exception $e) {}
        try { $this->db->query("ALTER TABLE t_sewa_lapangan DROP INDEX idx_slot_check"); } catch (\Exception $e) {}
        try { $this->db->query("ALTER TABLE t_jadwal DROP INDEX idx_jadwal_tanggal"); } catch (\Exception $e) {}
    }
}
