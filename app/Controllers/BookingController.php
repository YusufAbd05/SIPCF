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
            'bookings' => $bookings,
            'lapangs' => $lapangs,
            'totalBooking' => $totalBooking,
            'lunas' => $lunas,
            'pending' => $pending,
            'batal' => $batal,
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
        $excludeId = $this->request->getGet('exclude_id');
        
        if (!$tanggal) {
            return $this->response->setJSON([]);
        }

        // All schedule data is now in t_jadwal
        $jadwalModel = new \App\Models\JadwalModel();
        $excludeIdInt = $excludeId ? (int)$excludeId : null;
        $allSlots = $jadwalModel->getBookedSlotsForDate($tanggal, $excludeIdInt);

        $bookedMap = [];
        foreach ($allSlots as $s) {
            $lapangId = $s['id_lapang'];
            $jamMulai = (int) substr($s['jam_mulai'], 0, 2);
            $jamSelesai = (int) substr($s['jam_selesai'], 0, 2);

            if (!isset($bookedMap[$lapangId])) {
                $bookedMap[$lapangId] = [];
            }

            for ($h = $jamMulai; $h < $jamSelesai; $h++) {
                $slot = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                if (!in_array($slot, $bookedMap[$lapangId])) {
                    $bookedMap[$lapangId][] = $slot;
                }
            }
        }

        return $this->response->setJSON($bookedMap);
    }

    public function getKeuangan()
    {
        $idSewa = $this->request->getGet('id_sewa');
        if (!$idSewa) {
            return $this->response->setJSON([]);
        }

        $pembayaranModel = new PembayaranModel();
        $pembayaran = $pembayaranModel->where('id_sewa', $idSewa)->findAll();

        return $this->response->setJSON($pembayaran);
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

    public function save()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();

        // Ambil input pembayaran dinamis
        $totalBayar = (int) $this->request->getPost('total_bayar');
        $jumlahBayar = (int) $this->request->getPost('jumlah_bayar');
        $metode = $this->request->getPost('metode') ?? 'Cash';
        $tipePesanan = $this->request->getPost('tipe_pesanan') ?? 'Walk-in';

        // Tentukan status dan jenis pembayaran berdasarkan uang masuk vs total
        $jenisPembayaran = ($jumlahBayar < $totalBayar) ? 'DP' : 'Full';
        $statusPesanan = 'Dikonfirmasi'; // Status awal selalu Dikonfirmasi, pelunasan menjadi Selesai nanti dilakukan secara terpisah jika diperlukan, atau mainnya selesai.

        $tipeSewa = $this->request->getPost('tipe_sewa') ?? 'Per Jam'; // Default to Per Jam if not provided

        // Generate Kode Booking with correct prefix
        $prefix = 'BK';
        if ($tipeSewa === 'Harian' || $tipeSewa === 'Per Hari') $prefix = 'HR';
        elseif ($tipeSewa === 'Membership') $prefix = 'MB';

        $dateStr = date('Ymd');
        $countToday = $bookingModel->like('kode_sewa', "{$prefix}-{$dateStr}-")->countAllResults();
        $kodeSewa = "{$prefix}-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        $itemsJson = $this->request->getPost('items_json');
        $cartItems = [];
        if (!empty($itemsJson)) {
            $cartItems = json_decode($itemsJson, true);
        }

        $idLapang = $this->request->getPost('id_lapang'); // Fallback primary lapang ID
        $durasiJam = $this->request->getPost('durasi_jam'); // Total durasi

        // Save Booking (no schedule columns — those go to t_jadwal)
        $dataBooking = [
            'kode_sewa' => $kodeSewa,
            'id_lapang' => $idLapang,
            'nama_penyewa' => $this->request->getPost('nama_penyewa'),
            'no_hp_penyewa' => $this->request->getPost('no_hp'),
            'tipe_pesanan' => $tipePesanan,
            'tipe_sewa' => $tipeSewa,
            'durasi_jam' => $durasiJam,
            'total_bayar' => $totalBayar,
            'status_pesanan' => $statusPesanan,
        ];

        $bookingModel->insert($dataBooking);
        $idSewa = $bookingModel->getInsertID();

        // Save Jadwal
        $jadwalModel = new \App\Models\JadwalModel();
        
        if (!empty($cartItems) && is_array($cartItems)) {
            $sesiKe = 1;
            $lapangModel = new LapangModel();
            
            foreach ($cartItems as $item) {
                $jamMulai = $item['jam_mulai'];
                
                // For Harian mode, jadwal should cover full operating hours
                if ($tipeSewa === 'Harian') {
                    $lapangData = $lapangModel->find($item['id_lapang']);
                    if ($lapangData) {
                        $itemTanggal = $item['tanggal'] ?? $item['tanggal_main'] ?? date('Y-m-d');
                        $dow = date('w', strtotime($itemTanggal));
                        $isWeekend = ($dow == 0 || $dow == 6);
                        $opJamBuka = (int) ($isWeekend ? $lapangData['jam_buka_weekend'] : $lapangData['jam_buka_weekday']);
                        $opJamTutup = (int) ($isWeekend ? $lapangData['jam_tutup_weekend'] : $lapangData['jam_tutup_weekday']);
                        if ($opJamTutup <= $opJamBuka) $opJamTutup = 24;
                        
                        $jamMulai = str_pad($opJamBuka, 2, '0', STR_PAD_LEFT) . ':00';
                        $jamSelesai = str_pad($opJamTutup, 2, '0', STR_PAD_LEFT) . ':00';
                    } else {
                        $jamSelesai = str_pad((int)substr($jamMulai, 0, 2) + (int)$item['durasi'], 2, '0', STR_PAD_LEFT) . ':00';
                    }
                } else {
                    $jamSelesai = str_pad((int)substr($jamMulai, 0, 2) + (int)$item['durasi'], 2, '0', STR_PAD_LEFT) . ':00';
                }
                if ($tipeSewa === 'Membership') {
                    $baseDate = new \DateTime($item['tanggal'] ?? $item['tanggal_main'] ?? date('Y-m-d'));
                    for ($w = 0; $w < 4; $w++) {
                        $dateObj = clone $baseDate;
                        $dateObj->modify("+{$w} weeks");
                        $jadwalModel->insert([
                            'id_sewa'      => $idSewa,
                            'id_lapang'    => $item['id_lapang'],
                            'sesi_ke'      => $sesiKe++,
                            'tanggal_main' => $dateObj->format('Y-m-d'),
                            'jam_mulai'    => $jamMulai,
                            'jam_selesai'  => $jamSelesai,
                            'status_sesi'  => 'Terjadwal',
                        ]);
                    }
                } else {
                    $jadwalModel->insert([
                        'id_sewa'      => $idSewa,
                        'id_lapang'    => $item['id_lapang'],
                        'sesi_ke'      => $sesiKe++,
                        'tanggal_main' => $item['tanggal'] ?? $item['tanggal_main'] ?? date('Y-m-d'),
                        'jam_mulai'    => $jamMulai,
                        'jam_selesai'  => $jamSelesai,
                        'status_sesi'  => 'Terjadwal',
                    ]);
                }
            }
        } else {
            // Fallback for single item (if JSON not provided)
            if ($tipeSewa === 'Membership') {
                $baseDate = new \DateTime($this->request->getPost('tanggal_main'));
                for ($w = 0; $w < 4; $w++) {
                    $dateObj = clone $baseDate;
                    $dateObj->modify("+{$w} weeks");
                    $jadwalModel->insert([
                        'id_sewa'      => $idSewa,
                        'id_lapang'    => $idLapang,
                        'sesi_ke'      => $w + 1,
                        'tanggal_main' => $dateObj->format('Y-m-d'),
                        'jam_mulai'    => $this->request->getPost('jam_mulai'),
                        'jam_selesai'  => $this->request->getPost('jam_selesai'),
                        'status_sesi'  => 'Terjadwal',
                    ]);
                }
            } else {
                $jadwalModel->insert([
                    'id_sewa'      => $idSewa,
                    'id_lapang'    => $idLapang,
                    'sesi_ke'      => 1,
                    'tanggal_main' => $this->request->getPost('tanggal_main'),
                    'jam_mulai'    => $this->request->getPost('jam_mulai'),
                    'jam_selesai'  => $this->request->getPost('jam_selesai'),
                    'status_sesi'  => 'Terjadwal',
                ]);
            }
        }

        // Save Pembayaran (Dinamis: Lunas / DP)
        $dataPembayaran = [
            'id_sewa' => $idSewa,
            'jenis_pembayaran' => $jenisPembayaran,
            'jumlah_bayar' => $jumlahBayar,
            'metode' => $metode,
            'url_bukti_bayar' => null,
            'status_pembayaran' => 'Sukses',
            'waktu_pembayaran' => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        return redirect()->to('/admin/booking')->with('success', "Pesanan $tipePesanan berhasil ditambahkan dengan status pembayaran $jenisPembayaran!");
    }

    public function update()
    {
        $bookingModel = new BookingModel();
        $id = $this->request->getPost('id_sewa');

        // Update booking data (no schedule columns)
        $data = [
            'id_lapang' => $this->request->getPost('id_lapang'),
            'nama_penyewa' => $this->request->getPost('nama_penyewa'),
            'no_hp_penyewa' => $this->request->getPost('no_hp'),
            'durasi_jam' => $this->request->getPost('durasi_jam'),
            'total_bayar' => $this->request->getPost('total_bayar'),
            'tipe_sewa' => $this->request->getPost('tipe_sewa') ?? 'Per Jam',
        ];

        $bookingModel->update($id, $data);

        // Update jadwal
        $jadwalModel = new \App\Models\JadwalModel();
        $itemsJson = $this->request->getPost('items_json');

        if (!empty($itemsJson)) {
            $cartItems = json_decode($itemsJson, true);
            if (is_array($cartItems) && count($cartItems) > 0) {
                // Remove existing
                $jadwalModel->where('id_sewa', $id)->delete();
                
                // Re-insert
                $sesiKe = 1;
                $lapangModel = new LapangModel();
                $tipeSewa = $this->request->getPost('tipe_sewa') ?? 'Per Jam';
                
                foreach ($cartItems as $item) {
                    $jamMulai = $item['jam_mulai'];
                    
                    if ($tipeSewa === 'Harian') {
                        $lapangData = $lapangModel->find($item['id_lapang']);
                        if ($lapangData) {
                            $itemTanggal = $item['tanggal'] ?? $this->request->getPost('tanggal_main') ?? date('Y-m-d');
                            $dow = date('w', strtotime($itemTanggal));
                            $isWeekend = ($dow == 0 || $dow == 6);
                            $opJamBuka = (int) ($isWeekend ? $lapangData['jam_buka_weekend'] : $lapangData['jam_buka_weekday']);
                            $opJamTutup = (int) ($isWeekend ? $lapangData['jam_tutup_weekend'] : $lapangData['jam_tutup_weekday']);
                            if ($opJamTutup <= $opJamBuka) $opJamTutup = 24;
                            
                            $jamMulai = str_pad($opJamBuka, 2, '0', STR_PAD_LEFT) . ':00';
                            $jamSelesai = str_pad($opJamTutup, 2, '0', STR_PAD_LEFT) . ':00';
                        } else {
                            $itemJamMulaiHour = (int) substr($jamMulai, 0, 2);
                            $jamSelesai = str_pad($itemJamMulaiHour + (int)$item['durasi'], 2, '0', STR_PAD_LEFT) . ':00';
                        }
                    } else {
                        $itemJamMulaiHour = (int) substr($jamMulai, 0, 2);
                        $jamSelesai = str_pad($itemJamMulaiHour + (int)$item['durasi'], 2, '0', STR_PAD_LEFT) . ':00';
                    }
                    
                    $jadwalModel->insert([
                        'id_sewa'      => $id,
                        'id_lapang'    => $item['id_lapang'],
                        'sesi_ke'      => $sesiKe++,
                        'tanggal_main' => $item['tanggal'],
                        'jam_mulai'    => $jamMulai,
                        'jam_selesai'  => $jamSelesai,
                        'status_sesi'  => 'Terjadwal',
                    ]);
                }
            }
        } else {
            // Backward compatibility
            $jadwal = $jadwalModel->where('id_sewa', $id)->where('sesi_ke', 1)->first();
            if ($jadwal) {
                $jadwalModel->update($jadwal['id_jadwal'], [
                    'id_lapang'    => $this->request->getPost('id_lapang'),
                    'tanggal_main' => $this->request->getPost('tanggal_main'),
                    'jam_mulai'    => $this->request->getPost('jam_mulai'),
                    'jam_selesai'  => $this->request->getPost('jam_selesai'),
                ]);
            }
        }

        return redirect()->to('/admin/booking')->with('success', 'Data pesanan berhasil diperbarui!');
    }

    public function verifikasi()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();

        $idSewa = $this->request->getPost('id_sewa');
        $action = $this->request->getPost('action'); // 'terima' or 'tolak'
        
        $booking = $bookingModel->find($idSewa);

        if ($action === 'terima') {
            $bookingModel->update($idSewa, ['status_pesanan' => 'Dikonfirmasi', 'alasan_penolakan' => null]);
            // Update pembayaran status
            $pembayaran = $pembayaranModel->where('id_sewa', $idSewa)->first();
            if ($pembayaran) {
                $pembayaranModel->update($pembayaran['id_pembayaran'], ['status_pembayaran' => 'Sukses']);
            }
            if ($booking && !empty($booking['email_penyewa'])) {
                $jadwalModel = new \App\Models\JadwalModel();
                $booking['jadwals'] = $jadwalModel->select('t_jadwal.*, t_lapang.nama_lapangan')
                                                  ->join('t_lapang', 't_lapang.id_lapang = t_jadwal.id_lapang')
                                                  ->where('t_jadwal.id_sewa', $booking['id_sewa'])
                                                  ->orderBy('t_jadwal.sesi_ke', 'ASC')
                                                  ->findAll();

                $emailService = \Config\Services::email();
                $emailService->setTo($booking['email_penyewa']);
                $emailService->setSubject('Booking Dikonfirmasi: ' . $booking['kode_sewa']);
                $message = view('email/user_booking_approved', $booking, ['debug' => false]);
                $emailService->setMessage($message);
                $emailService->send();
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
            if ($booking && !empty($booking['email_penyewa'])) {
                $jadwalModel = new \App\Models\JadwalModel();
                $booking['jadwals'] = $jadwalModel->select('t_jadwal.*, t_lapang.nama_lapangan')
                                                  ->join('t_lapang', 't_lapang.id_lapang = t_jadwal.id_lapang')
                                                  ->where('t_jadwal.id_sewa', $booking['id_sewa'])
                                                  ->orderBy('t_jadwal.sesi_ke', 'ASC')
                                                  ->findAll();
                $booking['alasan_penolakan'] = $alasan; // pass the reason to the view

                $emailService = \Config\Services::email();
                $emailService->setTo($booking['email_penyewa']);
                $emailService->setSubject('Booking Ditolak: ' . $booking['kode_sewa']);
                $message = view('email/user_booking_rejected', $booking, ['debug' => false]);
                $emailService->setMessage($message);
                $emailService->send();
            }
            return redirect()->to('/admin/booking')->with('success', 'Pesanan telah ditolak dan dibatalkan.');
        }

        return redirect()->to('/admin/booking')->with('error', 'Aksi tidak valid.');
    }

    public function savePelunasan()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new PembayaranModel();

        $idSewa = $this->request->getPost('id_sewa');
        $jumlahBayar = (int) $this->request->getPost('jumlah_bayar');
        $metode = $this->request->getPost('metode') ?? 'Cash';

        // Update status_pesanan di t_sewa_lapangan menjadi 'Selesai'
        $bookingModel->update($idSewa, ['status_pesanan' => 'Selesai']);

        // Insert riwayat pembayaran baru untuk pelunasan
        $dataPembayaran = [
            'id_sewa' => $idSewa,
            'jenis_pembayaran' => 'Pelunasan',
            'jumlah_bayar' => $jumlahBayar,
            'metode' => $metode,
            'status_pembayaran' => 'Sukses',
            'waktu_pembayaran' => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        return redirect()->to('/admin/booking')->with('success', 'Pelunasan transaksi berhasil disimpan dan status menjadi Selesai!');
    }

}
