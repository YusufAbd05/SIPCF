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
        'email_penyewa',
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
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan')
            ->select('
                t_sewa_lapangan.*,
                GROUP_CONCAT(DISTINCT lp.nama_lapangan ORDER BY j1.sesi_ke SEPARATOR ", ") as nama_lapangan,
                MIN(j1.tanggal_main) as tanggal_main,
                MIN(j1.jam_mulai) as jam_mulai,
                MIN(j1.jam_selesai) as jam_selesai,
                MAX(t_pembayaran.metode) as metode_pembayaran,
                MAX(t_pembayaran.url_bukti_bayar) as url_bukti_bayar,
                SUM(DISTINCT t_pembayaran.jumlah_bayar) as jumlah_bayar,
                COUNT(DISTINCT j1.id_jadwal) as jumlah_item
            ')
            ->join('t_jadwal j1', 'j1.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->join('t_lapang lp', 'lp.id_lapang = j1.id_lapang', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->whereNotIn('t_sewa_lapangan.status_pesanan', ['Selesai'])
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy("FIELD(t_sewa_lapangan.status_pesanan, 'Ditolak','Dibatalkan')")
            ->orderBy('t_sewa_lapangan.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil data laporan booking berdasarkan filter tanggal dan lapangan.
     * Hanya booking dengan status Dikonfirmasi / Selesai.
     * Filter tanggal berdasarkan jadwal pertama (sesi_ke = 1).
     */
    public function getLaporanBookings(string $tglMulai, string $tglSelesai, string $idLapang = 'all'): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('t_sewa_lapangan')
            ->select('
                t_sewa_lapangan.*,
                GROUP_CONCAT(DISTINCT lp.nama_lapangan ORDER BY j1.sesi_ke SEPARATOR ", ") as nama_lapangan,
                MIN(j1.tanggal_main) as tanggal_main,
                MIN(j1.jam_mulai) as jam_mulai,
                MIN(j1.jam_selesai) as jam_selesai,
                SUM(DISTINCT t_pembayaran.jumlah_bayar) as jumlah_bayar,
                MAX(t_pembayaran.metode) as metode_pembayaran
            ')
            ->join('t_jadwal j1', 'j1.id_sewa = t_sewa_lapangan.id_sewa', 'left')
            ->join('t_lapang lp', 'lp.id_lapang = j1.id_lapang', 'left')
            ->join('t_pembayaran', 't_pembayaran.id_sewa = t_sewa_lapangan.id_sewa AND t_pembayaran.status_pembayaran = "Sukses"', 'left')
            ->where('j1.tanggal_main >=', $tglMulai)
            ->where('j1.tanggal_main <=', $tglSelesai)
            ->whereIn('t_sewa_lapangan.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('t_sewa_lapangan.id_sewa')
            ->orderBy('tanggal_main', 'DESC');

        if ($idLapang !== 'all') {
            $builder->where('j1.id_lapang', $idLapang);
        }

        return $builder->get()->getResultArray();
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

    // ─────────────────────────────────────────
    //  Dashboard Helper Methods
    // ─────────────────────────────────────────

    /**
     * Hitung jumlah booking berdasarkan status pesanan.
     */
    public function countByStatus(string $status): int
    {
        return $this->where('status_pesanan', $status)->countAllResults();
    }

    /**
     * Ambil N booking terbaru beserta nama lapangan.
     */
    public function getBookingTerbaru(int $limit = 5): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan s')
            ->select('s.kode_sewa, s.nama_penyewa, s.status_pesanan, s.total_bayar, s.created_at, l.nama_lapangan')
            ->join('t_lapang l', 'l.id_lapang = s.id_lapang', 'left')
            ->orderBy('s.created_at', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    /**
     * Hitung total booking dalam rentang tanggal (berdasarkan created_at).
     */
    public function countBookingBulan(string $tglAwal, string $tglAkhir): int
    {
        return $this->where('created_at >=', $tglAwal)
            ->where('created_at <=', $tglAkhir . ' 23:59:59')
            ->countAllResults();
    }

    /**
     * Hitung total transaksi bulan ini (Dikonfirmasi + Selesai) berdasarkan jadwal.
     */
    public function countTransaksiBulan(string $tglAwal, string $tglAkhir): int
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan s')
            ->join('t_jadwal j', 'j.id_sewa = s.id_sewa AND j.sesi_ke = 1', 'left')
            ->where('j.tanggal_main >=', $tglAwal)
            ->where('j.tanggal_main <=', $tglAkhir)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->countAllResults();
    }

    /**
     * Distribusi status booking dalam rentang tanggal.
     */
    public function getStatusDistribusi(string $tglAwal, string $tglAkhir): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan')
            ->select('status_pesanan, COUNT(*) as jumlah')
            ->where('created_at >=', $tglAwal)
            ->where('created_at <=', $tglAkhir . ' 23:59:59')
            ->groupBy('status_pesanan')
            ->get()->getResultArray();
    }

    /**
     * Ambil lapangan terlaris bulan ini.
     */
    public function getLapangTerlaris(string $tglAwal, string $tglAkhir): ?array
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan s')
            ->select('l.nama_lapangan, COUNT(*) as jumlah')
            ->join('t_lapang l', 'l.id_lapang = s.id_lapang', 'left')
            ->join('t_jadwal j', 'j.id_sewa = s.id_sewa AND j.sesi_ke = 1', 'left')
            ->where('j.tanggal_main >=', $tglAwal)
            ->where('j.tanggal_main <=', $tglAkhir)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('s.id_lapang')
            ->orderBy('jumlah', 'DESC')
            ->limit(1)
            ->get()->getRowArray();
    }
}
