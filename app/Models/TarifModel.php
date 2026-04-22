<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifModel extends Model
{
    protected $table = 't_lapang_tarif';
    protected $primaryKey = 'id_tarif';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_lapang',
        'nama_tarif',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'harga_umum',
        'harga_member',
    ];

    /**
     * Ambil semua tarif beserta nama lapangan (JOIN t_lapang)
     */
    public function getTarifWithLapang()
    {
        return $this->select('t_lapang_tarif.*, t_lapang.nama_lapangan')
            ->join('t_lapang', 't_lapang.id_lapang = t_lapang_tarif.id_lapang')
            ->findAll();
    }
}
