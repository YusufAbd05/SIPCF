<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\PembayaranModel;
use App\Models\LapangModel;
use App\Models\JadwalModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected BookingModel    $bookingModel;
    protected PembayaranModel $pembayaranModel;
    protected LapangModel     $lapangModel;
    protected JadwalModel     $jadwalModel;
    protected UserModel       $userModel;

    public function __construct()
    {
        $this->bookingModel    = new BookingModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->lapangModel     = new LapangModel();
        $this->jadwalModel     = new JadwalModel();
        $this->userModel       = new UserModel();
    }

    /**
     * Dashboard utama — konten berbeda per role.
     * Admin  : fokus operasional harian (verifikasi, booking hari ini)
     * Manajer: fokus overview bisnis (omset, grafik, status)
     * Owner  : fokus keuangan & performa (revenue, tren, metode bayar)
     */
    public function index()
    {
        $role = session()->get('role');
        $data = ['role' => $role];

        switch ($role) {
            case 'Admin':
                $today = date('Y-m-d');

                $data['sewaHariIni']        = $this->jadwalModel->countSewaHariIni($today);
                $data['menungguVerifikasi'] = $this->bookingModel->countByStatus('Menunggu Verifikasi');
                $data['dikonfirmasi']       = $this->bookingModel->countByStatus('Dikonfirmasi');
                $data['pendapatanHariIni']  = $this->pembayaranModel->getPendapatanHariIni($today);
                $data['bookingTerbaru']     = $this->bookingModel->getBookingTerbaru(5);
                $data['jadwalHariIni']      = $this->jadwalModel->getJadwalHariIni($today);
                break;

            case 'Manajer':
                $tglAwal   = date('Y-m-01');
                $tglAkhir  = date('Y-m-t');
                $tgl30Lalu = date('Y-m-d', strtotime('-30 days'));

                $pendapatanHarian = $this->pembayaranModel->getPendapatanHarianChart($tgl30Lalu, date('Y-m-d'));
                $chartLabels = [];
                $chartValues = [];
                foreach ($pendapatanHarian as $row) {
                    $chartLabels[] = date('d M', strtotime($row['tanggal_main']));
                    $chartValues[] = (int) ($row['pendapatan'] ?? 0);
                }

                $data['totalBookingBulan'] = $this->bookingModel->countBookingBulan($tglAwal, $tglAkhir);
                $data['omsetBulan']        = $this->pembayaranModel->getOmsetBulan($tglAwal, $tglAkhir);
                $data['lapanganAktif']     = $this->lapangModel->countAktif();
                $data['totalUser']         = $this->userModel->countTotal();
                $data['chartLabels']       = $chartLabels;
                $data['chartValues']       = $chartValues;
                $data['statusDistribusi']  = $this->bookingModel->getStatusDistribusi($tglAwal, $tglAkhir);
                break;

            case 'Owner':
                $tglAwal   = date('Y-m-01');
                $tglAkhir  = date('Y-m-t');
                $tgl30Lalu = date('Y-m-d', strtotime('-30 days'));

                $omsetBulanVal   = $this->pembayaranModel->getOmsetBulan($tglAwal, $tglAkhir);
                $totalTransaksi  = $this->bookingModel->countTransaksiBulan($tglAwal, $tglAkhir);
                $lapangTerlaris  = $this->bookingModel->getLapangTerlaris($tglAwal, $tglAkhir);
                $rataRata        = ($totalTransaksi > 0) ? (int) round($omsetBulanVal / $totalTransaksi) : 0;

                $pendapatanHarian = $this->pembayaranModel->getPendapatanHarianChart($tgl30Lalu, date('Y-m-d'));
                $chartLabels = [];
                $chartValues = [];
                foreach ($pendapatanHarian as $row) {
                    $chartLabels[] = date('d M', strtotime($row['tanggal_main']));
                    $chartValues[] = (int) ($row['pendapatan'] ?? 0);
                }

                $data['omsetBulan']       = $omsetBulanVal;
                $data['totalTransaksi']   = $totalTransaksi;
                $data['lapangTerlaris']   = $lapangTerlaris['nama_lapangan'] ?? '-';
                $data['rataRata']         = $rataRata;
                $data['chartLabels']      = $chartLabels;
                $data['chartValues']      = $chartValues;
                $data['metodeDistribusi'] = $this->pembayaranModel->getMetodeDistribusiBulan($tglAwal, $tglAkhir);
                break;
        }

        return view('admin/dashboard', $data);
    }
}
