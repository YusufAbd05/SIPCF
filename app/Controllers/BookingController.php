<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\PembayaranModel;
use App\Models\LapangModel;
use App\Models\TarifModel;

class BookingController extends BaseController
{
    public function index()
    {
        $bookingModel = new BookingModel();
        $lapangModel = new LapangModel();

        $bookings = $bookingModel->getBookingsWithDetails();
        $lapangs = $lapangModel->findAll();

        $totalBooking = count($bookings);
        $lunas = 0;
        $pending = 0;
        $batal = 0;

        foreach ($bookings as $b) {
            if ($b['status_pesanan'] === 'Dikonfirmasi' || $b['status_pesanan'] === 'Selesai') {
                $lunas++;
            } elseif ($b['status_pesanan'] === 'Menunggu Pembayaran' || $b['status_pesanan'] === 'Menunggu Verifikasi') {
                $pending++;
            } elseif ($b['status_pesanan'] === 'Ditolak' || $b['status_pesanan'] === 'Dibatalkan') {
                $batal++;
            }
        }

        $data = [
            'bookings'     => $bookings,
            'lapangs'      => $lapangs,
            'totalBooking' => $totalBooking,
            'lunas'        => $lunas,
            'pending'      => $pending,
            'batal'        => $batal,
        ];

        return view('admin/ViewBooking', $data);
    }

    /**
     * API: Ambil slot yang sudah terbooking untuk tanggal tertentu.
     * GET /admin/booking/getBookedSlots?tanggal=2026-04-22
     * Returns JSON: { "1": ["08:00","09:00","10:00"], "2": ["14:00","15:00"] }
     * Key = id_lapang, Value = array jam yang terblokir (per jam)
     */
    public function getBookedSlots()
    {
        $tanggal = $this->request->getGet('tanggal');
        if (!$tanggal) {
            return $this->response->setJSON([]);
        }

        $bookingModel = new BookingModel();

        // Ambil semua booking aktif (bukan Ditolak/Dibatalkan) untuk tanggal tersebut
        $bookings = $bookingModel
            ->where('tanggal_main', $tanggal)
            ->whereNotIn('status_pesanan', ['Ditolak', 'Dibatalkan'])
            ->findAll();

        $bookedMap = [];

        foreach ($bookings as $b) {
            $lapangId = $b['id_lapang'];
            $jamMulai = (int) substr($b['jam_mulai'], 0, 2);
            $jamSelesai = (int) substr($b['jam_selesai'], 0, 2);

            if (!isset($bookedMap[$lapangId])) {
                $bookedMap[$lapangId] = [];
            }

            // Expand range jam_mulai → jam_selesai menjadi per-jam
            // Contoh: 08:00 - 11:00 (3 jam) → ["08:00", "09:00", "10:00"]
            for ($h = $jamMulai; $h < $jamSelesai; $h++) {
                $slot = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                if (!in_array($slot, $bookedMap[$lapangId])) {
                    $bookedMap[$lapangId][] = $slot;
                }
            }
        }

        return $this->response->setJSON($bookedMap);
    }

    /**
     * API: Ambil tarif untuk lapang + hari tertentu.
     * GET /admin/booking/getTarif?id_lapang=1&tanggal=2026-04-22
     * Returns JSON: array of tarif rules applicable for that lapang & day category
     */
    public function getTarif()
    {
        $idLapang = $this->request->getGet('id_lapang');
        $tanggal = $this->request->getGet('tanggal');

        if (!$idLapang || !$tanggal) {
            return $this->response->setJSON([]);
        }

        // Tentukan kategori hari
        $dow = date('w', strtotime($tanggal)); // 0=Minggu, 6=Sabtu
        if ($dow == 0 || $dow == 6) {
            $kategoriHari = 'Weekend';
        } else {
            $kategoriHari = 'Weekday';
        }

        $tarifModel = new TarifModel();
        $tarifs = $tarifModel
            ->where('id_lapang', $idLapang)
            ->where('hari', $kategoriHari)
            ->findAll();

        // Jika tidak ada tarif spesifik, coba Libur Nasional juga
        if (empty($tarifs)) {
            $tarifs = $tarifModel
                ->where('id_lapang', $idLapang)
                ->findAll();
        }

        return $this->response->setJSON([
            'kategori_hari' => $kategoriHari,
            'tarifs' => $tarifs,
        ]);
    }

    public function saveWalkIn()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();

        // Generate Kode Booking
        $dateStr = date('Ymd');
        $countToday = $bookingModel->like('kode_sewa', "BK-{$dateStr}-")->countAllResults();
        $kodeSewa = "BK-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        // Save Booking
        $dataBooking = [
            'kode_sewa'      => $kodeSewa,
            'id_user'        => null,
            'id_lapang'      => $this->request->getPost('id_lapang'),
            'nama_penyewa'   => $this->request->getPost('nama_penyewa'),
            'no_hp_penyewa'  => $this->request->getPost('no_hp'),
            'tipe_pesanan'   => 'Walk-in',
            'tanggal_main'   => $this->request->getPost('tanggal_main'),
            'jam_mulai'      => $this->request->getPost('jam_mulai'),
            'jam_selesai'    => $this->request->getPost('jam_selesai'),
            'durasi_jam'     => $this->request->getPost('durasi_jam'),
            'total_bayar'    => $this->request->getPost('total_bayar'),
            'status_pesanan' => 'Dikonfirmasi',
        ];

        $bookingModel->insert($dataBooking);
        $idSewa = $bookingModel->getInsertID();

        // Save Pembayaran (Lunas, Cash)
        $dataPembayaran = [
            'id_sewa'           => $idSewa,
            'jenis_pembayaran'  => 'Full',
            'jumlah_bayar'      => $this->request->getPost('total_bayar'),
            'metode'            => 'Cash',
            'url_bukti_bayar'   => null,
            'status_pembayaran' => 'Sukses',
            'waktu_pembayaran'  => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        return redirect()->to('/admin/booking')->with('success', 'Pesanan Walk-in berhasil ditambahkan dan otomatis Lunas!');
    }

    public function update()
    {
        $bookingModel = new BookingModel();
        $id = $this->request->getPost('id_sewa');

        $data = [
            'id_lapang'    => $this->request->getPost('id_lapang'),
            'nama_penyewa' => $this->request->getPost('nama_penyewa'),
            'no_hp_penyewa'=> $this->request->getPost('no_hp'),
            'tanggal_main' => $this->request->getPost('tanggal_main'),
            'jam_mulai'    => $this->request->getPost('jam_mulai'),
            'jam_selesai'  => $this->request->getPost('jam_selesai'),
            'durasi_jam'   => $this->request->getPost('durasi_jam'),
            'total_bayar'  => $this->request->getPost('total_bayar'),
        ];

        $bookingModel->update($id, $data);

        return redirect()->to('/admin/booking')->with('success', 'Data pesanan berhasil diperbarui!');
    }

    public function verifikasi()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();
        
        $idSewa = $this->request->getPost('id_sewa');
        $action = $this->request->getPost('action'); // 'terima' or 'tolak'
        
        if ($action === 'terima') {
            $bookingModel->update($idSewa, ['status_pesanan' => 'Dikonfirmasi', 'alasan_penolakan' => null]);
            // Update pembayaran status
            $pembayaran = $pembayaranModel->where('id_sewa', $idSewa)->first();
            if ($pembayaran) {
                $pembayaranModel->update($pembayaran['id_pembayaran'], ['status_pembayaran' => 'Sukses']);
            }
            return redirect()->to('/admin/booking')->with('success', 'Pesanan berhasil diverifikasi dan dikonfirmasi!');
        } elseif ($action === 'tolak') {
            $alasan = $this->request->getPost('alasan_penolakan');
            $bookingModel->update($idSewa, ['status_pesanan' => 'Ditolak', 'alasan_penolakan' => $alasan]);
            // Update pembayaran status
            $pembayaran = $pembayaranModel->where('id_sewa', $idSewa)->first();
            if ($pembayaran) {
                $pembayaranModel->update($pembayaran['id_pembayaran'], ['status_pembayaran' => 'Ditolak']);
            }
            return redirect()->to('/admin/booking')->with('success', 'Pesanan telah ditolak dan dibatalkan.');
        }
        
        return redirect()->to('/admin/booking')->with('error', 'Aksi tidak valid.');
    }
}
