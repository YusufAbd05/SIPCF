<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 't_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_sewa',
        'jenis_pembayaran',
        'jumlah_bayar',
        'metode',
        'url_bukti_bayar',
        'status_pembayaran',
        'waktu_pembayaran'
    ];

    /**
     * Ambil distribusi metode pembayaran (untuk donut chart laporan).
     *
     * @param string $tglMulai   Format Y-m-d
     * @param string $tglSelesai Format Y-m-d
     * @param string $idLapang   ID lapang atau 'all'
     * @return array
     */
    public function getDistribusiMetode(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('t_sewa_lapangan s')
            ->select('p.metode, COUNT(*) as jumlah, SUM(p.jumlah_bayar) as total')
            ->join('t_jadwal j1', 'j1.id_sewa = s.id_sewa AND j1.sesi_ke = 1', 'inner')
            ->join('t_pembayaran p', 'p.id_sewa = s.id_sewa AND p.status_pembayaran = "Sukses"', 'inner')
            ->where('j1.tanggal_main >=', $tglMulai)
            ->where('j1.tanggal_main <=', $tglSelesai)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('p.metode')
            ->orderBy('total', 'DESC');

        if ($idLapang !== 'all') {
            $builder->where('s.id_lapang', $idLapang);
        }

        return $builder->get()->getResultArray();
    }
}
