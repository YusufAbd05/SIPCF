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

    // ─────────────────────────────────────────
    //  Dashboard Helper Methods
    // ─────────────────────────────────────────

    /**
     * Total pendapatan hari ini (pembayaran Sukses).
     */
    public function getPendapatanHariIni(string $tanggal): int
    {
        $db = \Config\Database::connect();
        $row = $db->table('t_pembayaran')
            ->selectSum('jumlah_bayar')
            ->where('status_pembayaran', 'Sukses')
            ->where('DATE(waktu_pembayaran)', $tanggal)
            ->get()->getRow();
        return (int) ($row->jumlah_bayar ?? 0);
    }

    /**
     * Omset bulan ini (pembayaran Sukses, berdasarkan tanggal jadwal).
     */
    public function getOmsetBulan(string $tglAwal, string $tglAkhir): int
    {
        $db = \Config\Database::connect();
        $row = $db->table('t_pembayaran p')
            ->selectSum('p.jumlah_bayar')
            ->join('t_sewa_lapangan s', 's.id_sewa = p.id_sewa')
            ->join('t_jadwal j', 'j.id_sewa = s.id_sewa AND j.sesi_ke = 1', 'left')
            ->where('j.tanggal_main >=', $tglAwal)
            ->where('j.tanggal_main <=', $tglAkhir)
            ->where('p.status_pembayaran', 'Sukses')
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->get()->getRow();
        return (int) ($row->jumlah_bayar ?? 0);
    }

    /**
     * Pendapatan harian untuk chart (30 hari terakhir atau rentang tertentu).
     */
    public function getPendapatanHarianChart(string $tglAwal, string $tglAkhir): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan s')
            ->select('j.tanggal_main, SUM(p.jumlah_bayar) as pendapatan')
            ->join('t_jadwal j', 'j.id_sewa = s.id_sewa AND j.sesi_ke = 1', 'left')
            ->join('t_pembayaran p', 'p.id_sewa = s.id_sewa AND p.status_pembayaran = "Sukses"', 'left')
            ->where('j.tanggal_main >=', $tglAwal)
            ->where('j.tanggal_main <=', $tglAkhir)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('j.tanggal_main')
            ->orderBy('j.tanggal_main', 'ASC')
            ->get()->getResultArray();
    }

    /**
     * Distribusi metode pembayaran bulan ini (untuk dashboard Owner).
     */
    public function getMetodeDistribusiBulan(string $tglAwal, string $tglAkhir): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_sewa_lapangan s')
            ->select('p.metode, COUNT(*) as jumlah, SUM(p.jumlah_bayar) as total')
            ->join('t_jadwal j', 'j.id_sewa = s.id_sewa AND j.sesi_ke = 1', 'inner')
            ->join('t_pembayaran p', 'p.id_sewa = s.id_sewa AND p.status_pembayaran = "Sukses"', 'inner')
            ->where('j.tanggal_main >=', $tglAwal)
            ->where('j.tanggal_main <=', $tglAkhir)
            ->whereIn('s.status_pesanan', ['Dikonfirmasi', 'Selesai'])
            ->groupBy('p.metode')
            ->orderBy('total', 'DESC')
            ->get()->getResultArray();
    }
}
