<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 't_sewa_lapangan';
    protected $primaryKey = 'id_sewa';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'kode_sewa',
        'id_user',
        'id_lapang',
        'nama_penyewa',
        'no_hp_penyewa',
        'tipe_pesanan',
        'tanggal_main',
        'jam_mulai',
        'jam_selesai',
        'durasi_jam',
        'total_bayar',
        'status_pesanan',
        'alasan_penolakan',
        'created_at'
    ];

    public function getBookingsWithDetails()
    {
        return $this->select('t_sewa_lapangan.*, t_lapang.nama_lapangan, t_user.role as user_role, t_pembayaran.metode as metode_pembayaran, t_pembayaran.url_bukti_bayar')
            ->join('t_lapang', 't_lapang.id_lapang = t_sewa_lapangan.id_lapang', 'left')
            ->join('t_user', 't_user.id_user = t_sewa_lapangan.id_user', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->orderBy('t_sewa_lapangan.created_at', 'DESC')
            ->findAll();
    }
}
