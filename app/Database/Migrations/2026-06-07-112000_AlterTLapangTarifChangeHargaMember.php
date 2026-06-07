<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTLapangTarifChangeHargaMember extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('harga_member', 't_lapang_tarif')) {
            $this->forge->modifyColumn('t_lapang_tarif', [
                'harga_member' => [
                    'name' => 'harga_harian',
                    'type' => 'INT',
                ]
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('harga_harian', 't_lapang_tarif')) {
            $this->forge->modifyColumn('t_lapang_tarif', [
                'harga_harian' => [
                    'name' => 'harga_member',
                    'type' => 'DECIMAL',
                    'constraint' => '12,2',
                    'default' => 0,
                ]
            ]);
        }
    }
}
