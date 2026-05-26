<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOwnerRole extends Migration
{
    public function up()
    {
        // Alter the 'role' column to include 'Owner' in the ENUM
        $this->db->query("ALTER TABLE t_user MODIFY COLUMN role ENUM('Admin','Manajer','Owner') NOT NULL DEFAULT 'Admin'");
    }

    public function down()
    {
        // Revert back to original ENUM (without Owner)
        $this->db->query("ALTER TABLE t_user MODIFY COLUMN role ENUM('Admin','Manajer') NOT NULL DEFAULT 'Admin'");
    }
}
