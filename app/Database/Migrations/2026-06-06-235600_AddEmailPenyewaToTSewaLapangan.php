<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailPenyewaToTSewaLapangan extends Migration
{
    public function up()
    {
        $fields = [
            'email_penyewa' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'no_hp_penyewa',
            ],
        ];
        $this->forge->addColumn('t_sewa_lapangan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_sewa_lapangan', 'email_penyewa');
    }
}
