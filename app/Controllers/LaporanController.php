<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\PembayaranModel;
use App\Models\LapangModel;

class LaporanController extends BaseController
{
    /**
     * Halaman utama Laporan Keuangan
     * Menampilkan ringkasan & tabel data berdasarkan filter tanggal/lapangan
     */
    public function index()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();
        $lapangModel = new LapangModel();

        // Default filter: bulan ini
        $tglMulai = $this->request->getGet('tgl_mulai') ?? date('Y-m-01');
        $tglSelesai = $this->request->getGet('tgl_selesai') ?? date('Y-m-t');
        $idLapang = $this->request->getGet('id_lapang') ?? 'all';

        // Ambil data dari model
        $lapangs = $lapangModel->findAll();
        $bookings = $bookingModel->getLaporanBookings($tglMulai, $tglSelesai, $idLapang);

        // ---- Hitung summary stats ----
        $totalPesanan = count($bookings);
        $totalOmset = 0;
        $lapangCount = [];

        foreach ($bookings as $b) {
            $totalOmset += (int) ($b['jumlah_bayar'] ?? 0);

            $namaLapang = $b['nama_lapangan'] ?? 'Unknown';
            if (!isset($lapangCount[$namaLapang])) {
                $lapangCount[$namaLapang] = 0;
            }
            $lapangCount[$namaLapang]++;
        }

        // Cari lapangan terlaris
        $lapangTerlaris = '-';
        if (!empty($lapangCount)) {
            arsort($lapangCount);
            $lapangTerlaris = array_key_first($lapangCount);
        }

        // Data chart & distribusi metode dari model
        $pendapatanHarian = $bookingModel->getPendapatanHarian($tglMulai, $tglSelesai, $idLapang);
        $chartData = $this->formatChartData($pendapatanHarian);
        $metodeDistribusi = $pembayaranModel->getDistribusiMetode($tglMulai, $tglSelesai, $idLapang);

        $data = [
            'bookings' => $bookings,
            'lapangs' => $lapangs,
            'tglMulai' => $tglMulai,
            'tglSelesai' => $tglSelesai,
            'idLapang' => $idLapang,
            'totalPesanan' => $totalPesanan,
            'totalOmset' => $totalOmset,
            'lapangTerlaris' => $lapangTerlaris,
            'chartData' => $chartData,
            'metodeDistribusi' => $metodeDistribusi,
        ];

        return view('admin/laporan', $data);
    }

    /**
     * API: Export data ke format JSON (bisa dipakai SheetJS / jsPDF di frontend)
     * GET /admin/laporan/exportData?tgl_mulai=...&tgl_selesai=...&id_lapang=all
     */
    public function exportData()
    {
        $bookingModel = new BookingModel();

        $tglMulai = $this->request->getGet('tgl_mulai') ?? date('Y-m-01');
        $tglSelesai = $this->request->getGet('tgl_selesai') ?? date('Y-m-t');
        $idLapang = $this->request->getGet('id_lapang') ?? 'all';

        $bookings = $bookingModel->getLaporanBookings($tglMulai, $tglSelesai, $idLapang);

        return $this->response->setJSON([
            'periode' => "$tglMulai s/d $tglSelesai",
            'total' => count($bookings),
            'data' => $bookings,
        ]);
    }

    /**
     * Format data pendapatan harian dari model ke format chart (labels + values)
     */
    private function formatChartData(array $pendapatanHarian): array
    {
        $labels = [];
        $values = [];
        foreach ($pendapatanHarian as $row) {
            $labels[] = date('d M', strtotime($row['tanggal_main']));
            $values[] = (int) ($row['pendapatan'] ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
