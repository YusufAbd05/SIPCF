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
        'id_lapang',
        'nama_penyewa',
        'no_hp_penyewa',
        'tipe_pesanan',
        'tipe_sewa',
        'durasi_jam',
        'total_bayar',
        'status_pesanan',
        'alasan_penolakan',
        'created_at'
    ];

    /**
     * Get bookings with lapangan, pembayaran, and first jadwal info.
     * Jadwal sesi_ke=1 is used to display tanggal & jam in the admin table.
     */
    public function getBookingsWithDetails()
    {
        return $this->select('
                t_sewa_lapangan.*,
                t_lapang.nama_lapangan,
                MIN(j1.tanggal_main) as tanggal_main,
                MIN(j1.jam_mulai) as jam_mulai,
                MIN(j1.jam_selesai) as jam_selesai,
                MAX(t_pembayaran.metode) as metode_pembayaran,
                MAX(t_pembayaran.url_bukti_bayar) as url_bukti_bayar,
                SUM(t_pembayaran.jumlah_bayar) as jumlah_bayar
            ')
            ->join('t_lapang', 't_lapang.id_lapang = t_sewa_lapangan.id_lapang', 'left')
            ->join('t_jadwal j1', 'j1.id_sewa = t_sewa_lapangan.id_sewa AND j1.sesi_ke = 1', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->whereNotIn('t_sewa_lapangan.status_pesanan', ['Selesai'])
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy("FIELD(t_sewa_lapangan.status_pesanan, 'Ditolak','Dibatalkan')", '', false)
            ->orderBy('t_sewa_lapangan.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Ambil data laporan booking berdasarkan filter tanggal dan lapangan.
     * Hanya booking dengan status Dikonfirmasi / Selesai.
     * Filter tanggal berdasarkan jadwal pertama (sesi_ke = 1).
     */
    public function getLaporanBookings(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $builder = $this->select('
                t_sewa_lapangan.*,
                t_lapang.nama_lapangan,
                MIN(j1.tanggal_main) as tanggal_main,
                MIN(j1.jam_mulai) as jam_mulai,
                MIN(j1.jam_selesai) as jam_selesai,
                SUM(t_pembayaran.jumlah_bayar) as jumlah_bayar,
                MAX(t_pembayaran.metode) as metode_pembayaran
            ')
            ->join('t_lapang', 't_lapang.id_lapang = t_sewa_lapangan.id_lapang', 'left')
            ->join('t_jadwal j1', 'j1.id_sewa = t_sewa_lapangan.id_sewa AND j1.sesi_ke = 1', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa AND t_pembayaran.status_pembayaran = "Sukses"', 'left')
            ->where('j1.tanggal_main >=', $tglMulai)
            ->where('j1.tanggal_main <=', $tglSelesai)
            ->whereIn('t_sewa_lapangan.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy('tanggal_main', 'DESC');

        if ($idLapang !== 'all') {
            $builder->where('t_sewa_lapangan.id_lapang', $idLapang);
        }

        return $builder->findAll();
    }

    /**
     * Ambil pendapatan harian (untuk grafik tren pendapatan).
     * Menggunakan tanggal dari t_jadwal sesi pertama.
     */
    public function getPendapatanHarian(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('t_sewa_lapangan s')
            ->select('j1.tanggal_main, SUM(p.jumlah_bayar) as pendapatan')
            ->join('t_jadwal j1', 'j1.id_sewa = s.id_sewa AND j1.sesi_ke = 1', 'left')
            ->join('t_pembayaran p', 'p.id_sewa = s.id_sewa AND p.status_pembayaran = "Sukses"', 'left')
            ->where('j1.tanggal_main >=', $tglMulai)
            ->where('j1.tanggal_main <=', $tglSelesai)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('j1.tanggal_main')
            ->orderBy('j1.tanggal_main', 'ASC');

        if ($idLapang !== 'all') {
            $builder->where('s.id_lapang', $idLapang);
        }

        return $builder->get()->getResultArray();
    }
}
