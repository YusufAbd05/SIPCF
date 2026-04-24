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
        return $this->select('t_sewa_lapangan.*, t_lapang.nama_lapangan, t_user.role as user_role, MAX(t_pembayaran.metode) as metode_pembayaran, MAX(t_pembayaran.url_bukti_bayar) as url_bukti_bayar, SUM(t_pembayaran.jumlah_bayar) as jumlah_bayar')
            ->join('t_lapang', 't_lapang.id_lapang = t_sewa_lapangan.id_lapang', 'left')
            ->join('t_user', 't_user.id_user = t_sewa_lapangan.id_user', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy('t_sewa_lapangan.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Ambil data laporan booking berdasarkan filter tanggal dan lapangan.
     * Hanya booking dengan status Dikonfirmasi / Selesai.
     *
     * @param string $tglMulai   Format Y-m-d
     * @param string $tglSelesai Format Y-m-d
     * @param string $idLapang   ID lapang atau 'all'
     * @return array
     */
    public function getLaporanBookings(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $builder = $this->select('
                t_sewa_lapangan.*,
                t_lapang.nama_lapangan,
                SUM(t_pembayaran.jumlah_bayar) as jumlah_bayar,
                MAX(t_pembayaran.metode) as metode_pembayaran
            ')
            ->join('t_lapang', 't_lapang.id_lapang = t_sewa_lapangan.id_lapang', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa AND t_pembayaran.status_pembayaran = "Sukses"', 'left')
            ->where('t_sewa_lapangan.tanggal_main >=', $tglMulai)
            ->where('t_sewa_lapangan.tanggal_main <=', $tglSelesai)
            ->whereIn('t_sewa_lapangan.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy('t_sewa_lapangan.tanggal_main', 'DESC');

        if ($idLapang !== 'all') {
            $builder->where('t_sewa_lapangan.id_lapang', $idLapang);
        }

        return $builder->findAll();
    }

    /**
     * Ambil pendapatan harian (untuk grafik tren pendapatan).
     *
     * @param string $tglMulai   Format Y-m-d
     * @param string $tglSelesai Format Y-m-d
     * @param string $idLapang   ID lapang atau 'all'
     * @return array
     */
    public function getPendapatanHarian(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('t_sewa_lapangan s')
            ->select('s.tanggal_main, SUM(p.jumlah_bayar) as pendapatan')
            ->join('t_pembayaran p', 'p.id_sewa = s.id_sewa AND p.status_pembayaran = "Sukses"', 'left')
            ->where('s.tanggal_main >=', $tglMulai)
            ->where('s.tanggal_main <=', $tglSelesai)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('s.tanggal_main')
            ->orderBy('s.tanggal_main', 'ASC');

        if ($idLapang !== 'all') {
            $builder->where('s.id_lapang', $idLapang);
        }

        return $builder->get()->getResultArray();
    }
}
