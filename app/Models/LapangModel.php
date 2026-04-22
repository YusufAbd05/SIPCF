<?php

namespace App\Models;

use CodeIgniter\Model;

class LapangModel extends Model
{
    protected $table = 't_lapang';
    protected $primaryKey = 'id_lapang';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_lapangan',
        'spesifikasi_lapang',
        'status_lapang',
        'jam_buka_weekday',
        'jam_tutup_weekday',
        'jam_buka_weekend',
        'jam_tutup_weekend',
    ];
}
