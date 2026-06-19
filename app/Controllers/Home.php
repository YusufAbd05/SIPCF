<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\LapangModel;
use App\Models\TarifModel;
use App\Models\JadwalModel;
use App\Models\PembayaranModel;

class Home extends BaseController
{
    public function index(): string
    {
        $lapangModel = new LapangModel();
        $lapangs = $lapangModel->where('status_lapang', 'Tersedia')->findAll();

        return view('index', [
            'lapangs' => $lapangs,
        ]);
    }

    public function ubahJadwal(): string
    {
        return view('UbahJadwal');
    }

    public function formulirBooking(): string
    {
        return view('FormulirBooking');
    }

    public function membership(): string
    {
        return view('Membership');
    }

    public function daftarMembership(): string
    {
        return view('DaftarMembership');
    }

    public function adminDashboard(): string
    {
        return view('admin/dashboard');
    }

    public function adminBooking(): string
    {
        return view('admin/ViewBooking');
    }

    // ───────────────────────────────────────────
    //  PUBLIC API (no auth required)
    // ───────────────────────────────────────────

    /**
     * GET /api/getLapangs
     * Returns JSON array of all available (Tersedia) lapangan with operating hours.
     */
    public function getLapangs()
    {
        $lapangModel = new LapangModel();
        $lapangs = $lapangModel->where('status_lapang', 'Tersedia')->findAll();
        return $this->response->setJSON($lapangs);
    }

    /**
     * GET /api/getBookedSlots?tanggal=2026-05-15
     * Returns JSON map: { "id_lapang": ["08:00","09:00",...], ... }
     * Only active bookings (not Ditolak/Dibatalkan) are included.
     */
    public function getBookedSlots()
    {
        $tanggal = $this->request->getGet('tanggal');
        if (!$tanggal) {
            return $this->response->setJSON([]);
        }

        // All schedule data is now in t_jadwal (Per Jam, Harian, Membership)
        $jadwalModel = new JadwalModel();
        $allSlots = $jadwalModel->getBookedSlotsForDate($tanggal);

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

    /**
     * GET /api/getMonthBookings?year=2026&month=5
     * Returns JSON map: { "2026-05-15": 5, "2026-05-20": 12, ... }
     * Value = total booked hour-slots for that date (across all lapangan).
     */
    public function getMonthBookings()
    {
        $year = $this->request->getGet('year');
        $month = $this->request->getGet('month');

        if (!$year || !$month) {
            return $this->response->setJSON([]);
        }

        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        // All schedule data is now in t_jadwal
        $db = \Config\Database::connect();
        $sessions = $db->table('t_jadwal j')
            ->select('j.tanggal_main, j.jam_mulai, j.jam_selesai')
            ->join('t_sewa_lapangan s', 's.id_sewa = j.id_sewa')
            ->where('j.tanggal_main >=', $startDate)
            ->where('j.tanggal_main <=', $endDate)
            ->where('j.status_sesi', 'Terjadwal')
            ->whereNotIn('s.status_pesanan', ['Ditolak', 'Dibatalkan'])
            ->get()
            ->getResultArray();

        $countMap = [];
        foreach ($sessions as $s) {
            $date = $s['tanggal_main'];
            $jamMulai = (int) substr($s['jam_mulai'], 0, 2);
            $jamSelesai = (int) substr($s['jam_selesai'], 0, 2);
            if ($jamSelesai <= $jamMulai)
                $jamSelesai = $jamMulai + 1;
            $slots = $jamSelesai - $jamMulai;

            if (!isset($countMap[$date])) {
                $countMap[$date] = 0;
            }
            $countMap[$date] += $slots;
        }

        return $this->response->setJSON($countMap);
    }

    /**
     * GET /api/getTarif?id_lapang=1&tanggal=2026-05-20
     * Returns JSON: { kategori_hari, tarifs[] }
     */
    public function getTarif()
    {
        $idLapang = $this->request->getGet('id_lapang');
        $tanggal = $this->request->getGet('tanggal');

        if (!$idLapang || !$tanggal) {
            return $this->response->setJSON([]);
        }

        $dow = date('w', strtotime($tanggal));
        $kategoriHari = ($dow == 0 || $dow == 6) ? 'Weekend' : 'Weekday';

        $tarifModel = new \App\Models\TarifModel();
        $tarifs = $tarifModel
            ->where('id_lapang', $idLapang)
            ->where('hari', $kategoriHari)
            ->findAll();

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

    /**
     * POST /booking
     * Handles public booking form submission.
     */
    public function saveBooking()
    {
        $bookingModel = new BookingModel();
        $pembayaranModel = new \App\Models\PembayaranModel();

        // ── Validation ──
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'whatsapp' => 'required|min_length[10]|max_length[15]',
            'id_lapang' => 'required|numeric',
            'tanggal_main' => 'required|valid_date',
            'jam_mulai' => 'required',
            'durasi' => 'required|numeric|greater_than[0]',
            'total_bayar' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Data tidak valid. Pastikan semua field terisi dengan benar.');
        }

        // ── Validate date is not in the past ──
        $tanggalMain = $this->request->getPost('tanggal_main');
        if ($tanggalMain < date('Y-m-d')) {
            return redirect()->back()->withInput()
                ->with('error', 'Tanggal yang dipilih sudah lewat.');
        }

        // ── Common data ──
        $jamMulai = $this->request->getPost('jam_mulai');
        $durasi = (int) $this->request->getPost('durasi');
        $tipeSewa = $this->request->getPost('tipe_sewa') ?? 'Per Jam';
        $idLapang = $this->request->getPost('id_lapang');
        $totalBayar = (int) $this->request->getPost('total_bayar');
        $jamMulaiHour = (int) substr($jamMulai, 0, 2);
        $emailPenyewa = $this->request->getPost('email');

        // ── Upload Bukti Bayar (shared across all modes) ──
        $buktiFile = $this->request->getFile('bukti_bayar');
        $urlBukti = null;

        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            $tempName = 'BUKTI_' . date('Ymd_His') . '_' . $buktiFile->getRandomName();
            $buktiFile->move(FCPATH . 'uploads/bukti_bayar', $tempName);
            $urlBukti = 'uploads/bukti_bayar/' . $tempName;
        }

        // ═══════════════════════════════════════════════
        //  MODE: MEMBERSHIP (4x Main Mingguan)
        //  → 1 booking record + 4 jadwal_membership records
        // ═══════════════════════════════════════════════
        if ($tipeSewa === 'Membership') {
            $jamSelesai = str_pad($jamMulaiHour + $durasi, 2, '0', STR_PAD_LEFT) . ':00';

            // Generate 4 weekly dates from the selected date
            $dates = [];
            $baseDate = new \DateTime($tanggalMain);
            for ($i = 0; $i < 4; $i++) {
                $date = clone $baseDate;
                $date->modify("+{$i} weeks");
                $dates[] = $date->format('Y-m-d');
            }

            // Validate slot availability for ALL 4 dates via t_jadwal
            $jadwalModel = new JadwalModel();
            foreach ($dates as $date) {
                $allSlots = $jadwalModel->getBookedSlotsForDate($date);

                $occupied = [];
                foreach ($allSlots as $s) {
                    if ((string) $s['id_lapang'] === (string) $idLapang) {
                        $sStart = (int) substr($s['jam_mulai'], 0, 2);
                        $sEnd = (int) substr($s['jam_selesai'], 0, 2);
                        for ($h = $sStart; $h < $sEnd; $h++) {
                            $occupied[] = $h;
                        }
                    }
                }

                for ($h = $jamMulaiHour; $h < $jamMulaiHour + $durasi; $h++) {
                    if (in_array($h, $occupied)) {
                        $readableDate = date('d M Y', strtotime($date));
                        return redirect()->back()->withInput()
                            ->with('error', "Maaf, jam yang Anda pilih sudah terisi pada tanggal {$readableDate}. Silakan pilih jam lain.");
                    }
                }
            }

            // Generate kode (MB prefix for membership)
            $dateStr = date('Ymd');
            $countToday = $bookingModel->like('kode_sewa', "MB-{$dateStr}-")->countAllResults();
            $kodeSewa = "MB-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

            // Create 1 booking record
            $dataBooking = [
                'kode_sewa' => $kodeSewa,
                'id_lapang' => $idLapang,
                'nama_penyewa' => $this->request->getPost('nama'),
                'no_hp_penyewa' => $this->request->getPost('whatsapp'),
                'email_penyewa' => $emailPenyewa,
                'tipe_pesanan' => 'Online',
                'tipe_sewa' => 'Membership',
                'durasi_jam' => $durasi,
                'total_bayar' => $totalBayar,
                'status_pesanan' => 'Menunggu Verifikasi',
            ];

            $bookingModel->insert($dataBooking);
            $idSewa = $bookingModel->getInsertID();

            // Create 4 jadwal records
            foreach ($dates as $idx => $date) {
                $jadwalModel->insert([
                    'id_sewa' => $idSewa,
                    'id_lapang' => $idLapang,
                    'sesi_ke' => $idx + 1,
                    'tanggal_main' => $date,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'status_sesi' => 'Terjadwal',
                ]);
            }

            // Create 1 pembayaran
            $dataPembayaran = [
                'id_sewa' => $idSewa,
                'jenis_pembayaran' => 'Full',
                'jumlah_bayar' => $totalBayar,
                'metode' => 'Transfer Bank',
                'url_bukti_bayar' => $urlBukti,
                'status_pembayaran' => 'Pending',
                'waktu_pembayaran' => date('Y-m-d H:i:s'),
            ];
            $pembayaranModel->insert($dataPembayaran);

            // Kirim notifikasi email ke Admin
            $userModel = new \App\Models\UserModel();
            $admins = $userModel->where('role', 'Admin')->findAll();
            $adminEmails = array_filter(array_column($admins, 'email'));

            if (!empty($adminEmails)) {
                $emailService = \Config\Services::email();
                $emailService->setTo($adminEmails);
                $emailService->setSubject('Booking Baru (' . $dataBooking['tipe_sewa'] . '): ' . $dataBooking['kode_sewa']);
                $message = view('email/admin_new_booking', $dataBooking, ['debug' => false]);
                $emailService->setMessage($message);
                $emailService->send();
            }

            return redirect()->to('/booking?success=1&kode=' . $kodeSewa)
                ->with('booking_success', true)
                ->with('kode_sewa', $kodeSewa);
        }

        // ═══════════════════════════════════════════════
        //  MODE: HARIAN (Full Day, multi-day support)
        //  → 1 booking record + N jadwal records (1 per day)
        // ═══════════════════════════════════════════════
                if ($tipeSewa === 'Harian') {
            $lapangModel = new LapangModel();
            
            $itemsJson = $this->request->getPost('items_json');
            $cartItems = [];
            if (!empty($itemsJson)) {
                $cartItems = json_decode($itemsJson, true);
            }

            // Fallback for single item mode if JSON is empty or parsing failed
            if (empty($cartItems)) {
                $cartItems = [[
                    'id_lapang' => $idLapang,
                    'tanggal' => $this->request->getPost('tanggal_main'),
                    'durasi' => max(1, (int) $this->request->getPost('jumlah_hari'))
                ]];
            }

            // To hold all jadwal to be inserted later
            $allJadwalToInsert = [];
            $totalDurasiPerHariAllItems = 0;
            $jadwalModel = new JadwalModel();

            foreach ($cartItems as $item) {
                $itemIdLapang = $item['id_lapang'];
                $itemTanggal = $item['tanggal'] ?? $item['tanggal_main'] ?? date('Y-m-d');
                $itemDurasiHari = (int) $item['durasi'];

                $lapangData = $lapangModel->find($itemIdLapang);
                if (!$lapangData) continue;

                // Determine base operating hours
                $baseJamBuka = 8;
                $baseJamTutup = 20;

                // Generate consecutive dates for this item
                $dates = [];
                $baseDate = new \DateTime($itemTanggal);
                for ($i = 0; $i < $itemDurasiHari; $i++) {
                    $date = clone $baseDate;
                    $date->modify("+{$i} days");
                    $dates[] = $date->format('Y-m-d');
                }

                foreach ($dates as $idx => $date) {
                    $dow = date('w', strtotime($date));
                    $isWeekend = ($dow == 0 || $dow == 6);
                    $opJamBuka = (int) ($isWeekend ? $lapangData['jam_buka_weekend'] : $lapangData['jam_buka_weekday']);
                    $opJamTutup = (int) ($isWeekend ? $lapangData['jam_tutup_weekend'] : $lapangData['jam_tutup_weekday']);
                    if ($opJamTutup <= $opJamBuka) $opJamTutup = 24;

                    $totalDurasiPerHariAllItems += ($opJamTutup - $opJamBuka);

                    // Validate slot availability for this date
                    $allSlots = $jadwalModel->getBookedSlotsForDate($date);
                    $occupied = [];
                    foreach ($allSlots as $s) {
                        if ((string) $s['id_lapang'] === (string) $itemIdLapang) {
                            $sStart = (int) substr($s['jam_mulai'], 0, 2);
                            $sEnd = (int) substr($s['jam_selesai'], 0, 2);
                            for ($h = $sStart; $h < $sEnd; $h++) {
                                $occupied[] = $h;
                            }
                        }
                    }

                    for ($h = $opJamBuka; $h < $opJamTutup; $h++) {
                        if (in_array($h, $occupied)) {
                            $readableDate = date('d M Y', strtotime($date));
                            return redirect()->back()->withInput()
                                ->with('error', "Maaf, lapangan {$lapangData['nama_lapangan']} sudah terisi pada tanggal {$readableDate}. Silakan pilih tanggal lain.");
                        }
                    }

                    // Prepare to insert
                    $allJadwalToInsert[] = [
                        'id_lapang' => $itemIdLapang,
                        'tanggal_main' => $date,
                        'jam_mulai' => str_pad($opJamBuka, 2, '0', STR_PAD_LEFT) . ':00',
                        'jam_selesai' => str_pad($opJamTutup, 2, '0', STR_PAD_LEFT) . ':00',
                        'status_sesi' => 'Terjadwal',
                    ];
                }
            }

            // Generate kode (HR prefix for harian)
            $dateStr = date('Ymd');
            $countToday = $bookingModel->like('kode_sewa', "HR-{$dateStr}-")->countAllResults();
            $kodeSewa = "HR-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

            // Create 1 booking record
            $dataBooking = [
                'kode_sewa' => $kodeSewa,
                'id_lapang' => $idLapang, // Fallback main id_lapang for foreign key constraints if any
                'nama_penyewa' => $this->request->getPost('nama'),
                'no_hp_penyewa' => $this->request->getPost('whatsapp'),
                'email_penyewa' => $emailPenyewa,
                'tipe_pesanan' => 'Online',
                'tipe_sewa' => 'Harian',
                'durasi_jam' => $totalDurasiPerHariAllItems,
                'total_bayar' => $totalBayar,
                'status_pesanan' => 'Menunggu Verifikasi',
            ];

            $bookingModel->insert($dataBooking);
            $idSewa = $bookingModel->getInsertID();

            // Insert Jadwal records
            $sesiKe = 1;
            foreach ($allJadwalToInsert as $jadwalData) {
                $jadwalData['id_sewa'] = $idSewa;
                $jadwalData['sesi_ke'] = $sesiKe++;
                $jadwalModel->insert($jadwalData);
            }

            // Create 1 pembayaran
            $jenisBayar = $this->request->getPost('jenis_pembayaran') ?? 'Full';
            $jumlahBayar = ($jenisBayar === 'DP') ? (int) ceil($totalBayar / 2) : $totalBayar;
            $dataPembayaran = [
                'id_sewa' => $idSewa,
                'jenis_pembayaran' => $jenisBayar,
                'jumlah_bayar' => $jumlahBayar,
                'metode' => 'Transfer Bank',
                'url_bukti_bayar' => $urlBukti,
                'status_pembayaran' => 'Pending',
                'waktu_pembayaran' => date('Y-m-d H:i:s'),
            ];
            $pembayaranModel->insert($dataPembayaran);

            // Kirim Email ke Admin
            $userModel = new \App\Models\UserModel();
            $admins = $userModel->where('role', 'Admin')->findAll();
            $emails = [];
            foreach ($admins as $admin) {
                if (!empty($admin['email'])) {
                    $emails[] = $admin['email'];
                }
            }

            if (!empty($emails)) {
                $jadwals = [];
                $booking = $bookingModel->where('kode_sewa', $dataBooking['kode_sewa'])->first();
                if ($booking) {
                    $jadwals = $jadwalModel->select('t_jadwal.*, t_lapang.nama_lapangan')
                                           ->join('t_lapang', 't_lapang.id_lapang = t_jadwal.id_lapang')
                                           ->where('t_jadwal.id_sewa', $booking['id_sewa'])
                                           ->orderBy('t_jadwal.sesi_ke', 'ASC')
                                           ->findAll();
                }
                $dataBooking['jadwals'] = $jadwals;
                $dataBooking['no_hp'] = $dataBooking['no_hp_penyewa'];

                $emailService = \Config\Services::email();
                $emailService->setTo($emails);
                $emailService->setSubject('Pesanan Booking Baru: ' . $dataBooking['kode_sewa']);
                $message = view('email/admin_new_booking', $dataBooking, ['debug' => false]);
                $emailService->setMessage($message);
                $emailService->send();
            }

            return redirect()->to('/booking?success=1&kode=' . $kodeSewa)
                ->with('booking_success', true)
                ->with('kode_sewa', $kodeSewa);
        }

        // ═══════════════════════════════════════════════
        //  MODE: PER JAM — Multi-Item Cart Support
        //  → 1 booking record + N jadwal records (1 per item)
        // ═══════════════════════════════════════════════

        // Check if cart items are submitted (multi-item mode)
        $itemsJson = $this->request->getPost('items_json');
        $cartItems = [];

        if ($itemsJson) {
            $cartItems = json_decode($itemsJson, true);
            if (!is_array($cartItems) || empty($cartItems)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Data keranjang booking tidak valid.');
            }
        } else {
            // Backward compat: single item from old form
            $jamSelesai = str_pad($jamMulaiHour + $durasi, 2, '0', STR_PAD_LEFT) . ':00';
            $cartItems = [[
                'id_lapang' => $idLapang,
                'tanggal'   => $tanggalMain,
                'jam_mulai' => $jamMulai,
                'durasi'    => $durasi,
            ]];
        }

        // ── Validate all items ──
        $jadwalModel = new JadwalModel();
        $tarifModel  = new TarifModel();
        $calculatedTotal = 0;

        foreach ($cartItems as $idx => $item) {
            $itemLapang  = $item['id_lapang'];
            $itemTanggal = $item['tanggal'];
            $itemJam     = $item['jam_mulai'];
            $itemDurasi  = (int) ($item['durasi'] ?? 1);
            $itemJamHour = (int) substr($itemJam, 0, 2);
            $itemJamSelesai = str_pad($itemJamHour + $itemDurasi, 2, '0', STR_PAD_LEFT) . ':00';

            // Validate date not in the past
            if ($itemTanggal < date('Y-m-d')) {
                return redirect()->back()->withInput()
                    ->with('error', 'Item #' . ($idx + 1) . ': Tanggal sudah lewat.');
            }

            // Check slot availability
            $allSlots = $jadwalModel->getBookedSlotsForDate($itemTanggal);
            $occupiedHours = [];
            foreach ($allSlots as $s) {
                if ((string) $s['id_lapang'] === (string) $itemLapang) {
                    $sStart = (int) substr($s['jam_mulai'], 0, 2);
                    $sEnd   = (int) substr($s['jam_selesai'], 0, 2);
                    for ($h = $sStart; $h < $sEnd; $h++) {
                        $occupiedHours[] = $h;
                    }
                }
            }

            for ($h = $itemJamHour; $h < $itemJamHour + $itemDurasi; $h++) {
                if (in_array($h, $occupiedHours)) {
                    return redirect()->back()->withInput()
                        ->with('error', 'Item #' . ($idx + 1) . ': Jam yang dipilih sudah terisi. Silakan pilih jam lain.');
                }
            }

            // Calculate price for this item
            $dow = date('w', strtotime($itemTanggal));
            $kategoriHari = ($dow == 0 || $dow == 6) ? 'Weekend' : 'Weekday';
            $tarifs = $tarifModel->where('id_lapang', $itemLapang)->where('hari', $kategoriHari)->findAll();
            if (empty($tarifs)) {
                $tarifs = $tarifModel->where('id_lapang', $itemLapang)->findAll();
            }

            $itemHarga = 0;
            for ($h = $itemJamHour; $h < $itemJamHour + $itemDurasi; $h++) {
                $hargaSlot = 0;
                foreach ($tarifs as $t) {
                    $tStart = (int) substr($t['jam_mulai'], 0, 2);
                    $tEnd   = (int) substr($t['jam_selesai'], 0, 2);
                    if ($h >= $tStart && $h < $tEnd && $t['harga_umum'] > 0) {
                        $hargaSlot = (int) $t['harga_umum'];
                        break;
                    }
                }
                if ($hargaSlot === 0 && !empty($tarifs)) {
                    foreach ($tarifs as $t) {
                        if ($t['harga_umum'] > 0) {
                            $hargaSlot = (int) $t['harga_umum'];
                            break;
                        }
                    }
                }
                $itemHarga += $hargaSlot;
            }
            $calculatedTotal += $itemHarga;

            // Store calculated values back in item
            $cartItems[$idx]['jam_selesai'] = $itemJamSelesai;
            $cartItems[$idx]['harga']       = $itemHarga;
        }

        // Use server-calculated total (more secure)
        $finalTotal = $calculatedTotal > 0 ? $calculatedTotal : $totalBayar;

        // ── Generate Kode Booking ──
        $dateStr = date('Ymd');
        $countToday = $bookingModel->like('kode_sewa', "BK-{$dateStr}-")->countAllResults();
        $kodeSewa = "BK-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        // ── Save Booking (1 record) ──
        $totalDurasi = array_sum(array_column($cartItems, 'durasi'));
        $dataBooking = [
            'kode_sewa'      => $kodeSewa,
            'id_lapang'      => $cartItems[0]['id_lapang'], // first item for backward compat
            'nama_penyewa'   => $this->request->getPost('nama'),
            'no_hp_penyewa'  => $this->request->getPost('whatsapp'),
            'email_penyewa'  => $emailPenyewa,
            'tipe_pesanan'   => 'Online',
            'tipe_sewa'      => 'Per Jam',
            'durasi_jam'     => $totalDurasi,
            'total_bayar'    => $finalTotal,
            'status_pesanan' => 'Menunggu Verifikasi',
        ];

        $bookingModel->insert($dataBooking);
        $idSewa = $bookingModel->getInsertID();

        // ── Save Jadwal (N records — 1 per cart item) ──
        foreach ($cartItems as $idx => $item) {
            $jadwalModel->insert([
                'id_sewa'      => $idSewa,
                'id_lapang'    => $item['id_lapang'],
                'sesi_ke'      => $idx + 1,
                'tanggal_main' => $item['tanggal'],
                'jam_mulai'    => $item['jam_mulai'],
                'jam_selesai'  => $item['jam_selesai'],
                'status_sesi'  => 'Terjadwal',
            ]);
        }

        // ── Save Pembayaran ──
        $jenisBayar = $this->request->getPost('jenis_pembayaran') ?? 'Full';
        $jumlahBayar = ($jenisBayar === 'DP') ? (int) ceil($finalTotal / 2) : $finalTotal;
        $dataPembayaran = [
            'id_sewa'           => $idSewa,
            'jenis_pembayaran'  => $jenisBayar,
            'jumlah_bayar'      => $jumlahBayar,
            'metode'            => 'Transfer Bank',
            'url_bukti_bayar'   => $urlBukti,
            'status_pembayaran' => 'Pending',
            'waktu_pembayaran'  => date('Y-m-d H:i:s'),
        ];
        $pembayaranModel->insert($dataPembayaran);

        // ── Redirect to success page ──
        // Kirim Email ke Admin
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('role', 'Admin')->findAll();
        $emails = [];
        foreach ($admins as $admin) {
            if (!empty($admin['email'])) {
                $emails[] = $admin['email'];
            }
        }

        if (!empty($emails)) {
            $jadwals = [];
            $booking = $bookingModel->where('kode_sewa', $dataBooking['kode_sewa'])->first();
            if ($booking) {
                $jadwals = $jadwalModel->select('t_jadwal.*, t_lapang.nama_lapangan')
                                       ->join('t_lapang', 't_lapang.id_lapang = t_jadwal.id_lapang')
                                       ->where('t_jadwal.id_sewa', $booking['id_sewa'])
                                       ->orderBy('t_jadwal.sesi_ke', 'ASC')
                                       ->findAll();
            }
            $dataBooking['jadwals'] = $jadwals;
            $dataBooking['no_hp'] = $dataBooking['no_hp_penyewa'];

            $emailService = \Config\Services::email();
            $emailService->setTo($emails);
            $emailService->setSubject('Pesanan Booking Baru: ' . $dataBooking['kode_sewa']);
            $message = view('email/admin_new_booking', $dataBooking, ['debug' => false]);
            $emailService->setMessage($message);
            $emailService->send();
        }

        return redirect()->to('/booking?success=1&kode=' . $kodeSewa)
            ->with('booking_success', true)
            ->with('kode_sewa', $kodeSewa);
    }

    // ───────────────────────────────────────────
    //  UC-3: Ubah Jadwal (Public APIs)
    // ───────────────────────────────────────────

    /**
     * GET /api/lookupBooking?kode=BK-20260515-001
     * Lookup a booking by kode_sewa. Returns booking details + lapang name.
     * Only active bookings (Menunggu, Menunggu Verifikasi, Dikonfirmasi) are eligible.
     */
    public function lookupBooking()
    {
        $kode = $this->request->getGet('kode');
        if (!$kode) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode booking wajib diisi.']);
        }

        $bookingModel = new BookingModel();
        $lapangModel = new LapangModel();

        // Find booking by kode_sewa
        $booking = $bookingModel->where('kode_sewa', $kode)->first();

        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode booking tidak ditemukan. Periksa kembali kode Anda.']);
        }

        // Only allow reschedule for active statuses
        $allowedStatuses = ['Menunggu', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikonfirmasi'];
        if (!in_array($booking['status_pesanan'], $allowedStatuses)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Booking dengan status "' . $booking['status_pesanan'] . '" tidak dapat diubah jadwalnya.'
            ]);
        }

        // Get all jadwals
        $jadwalModel = new JadwalModel();
        $jadwals = $jadwalModel->select('t_jadwal.*, t_lapang.nama_lapangan')
                               ->join('t_lapang', 't_lapang.id_lapang = t_jadwal.id_lapang')
                               ->where('t_jadwal.id_sewa', $booking['id_sewa'])
                               ->orderBy('t_jadwal.sesi_ke', 'ASC')
                               ->findAll();

        if (empty($jadwals)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada jadwal ditemukan untuk pesanan ini.']);
        }

        // Add duration to each jadwal
        foreach ($jadwals as &$j) {
            $j['durasi'] = (int)substr($j['jam_selesai'], 0, 2) - (int)substr($j['jam_mulai'], 0, 2);
            if ($j['durasi'] <= 0) $j['durasi'] = 1;
        }

        // Calculate Sisa Bayar
        $pembayaranModel = new \App\Models\PembayaranModel();
        $pembayaran = $pembayaranModel->where('id_sewa', $booking['id_sewa'])->findAll();
        $sudahDibayar = 0;
        foreach($pembayaran as $p) {
            if ($p['status_pembayaran'] === 'Sukses') {
                $sudahDibayar += (int)$p['jumlah_bayar'];
            }
        }
        $sisaBayar = (int)$booking['total_bayar'] - $sudahDibayar;
        if ($sisaBayar < 0) $sisaBayar = 0;

        return $this->response->setJSON([
            'success' => true,
            'booking' => [
                'id_sewa' => $booking['id_sewa'],
                'kode_sewa' => $booking['kode_sewa'],
                'nama_penyewa' => $booking['nama_penyewa'],
                'total_bayar' => $booking['total_bayar'],
                'status_pesanan' => $booking['status_pesanan'],
                'tipe_pesanan' => $booking['tipe_pesanan'],
                'sisa_bayar' => $sisaBayar,
            ],
            'jadwals' => $jadwals
        ]);
    }

    /**
     * POST /api/ubahJadwal
     * Reschedule a booking: update tanggal_main, jam_mulai, jam_selesai.
     * Validates slot availability and reschedule deadline.
     */
    public function processUbahJadwalItem()
    {
        $bookingModel = new BookingModel();
        $jadwalModel = new JadwalModel();

        $kodeSewa = $this->request->getPost('kode_sewa');
        $idJadwal = $this->request->getPost('id_jadwal');
        $tanggalBaru = $this->request->getPost('tanggal_baru');
        $jamMulaiBaru = $this->request->getPost('jam_mulai_baru');
        $durasiBaruInput = $this->request->getPost('durasi_baru');

        if (!$kodeSewa || !$idJadwal || !$tanggalBaru || !$jamMulaiBaru) {
            return $this->response->setJSON(['success' => false, 'message' => 'Semua field wajib diisi.']);
        }

        $booking = $bookingModel->where('kode_sewa', $kodeSewa)->first();
        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode booking tidak ditemukan.']);
        }

        $allowedStatuses = ['Menunggu', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikonfirmasi'];
        if (!in_array($booking['status_pesanan'], $allowedStatuses)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Booking ini tidak dapat diubah jadwalnya.']);
        }

        $jadwal = $jadwalModel->where('id_jadwal', $idJadwal)->where('id_sewa', $booking['id_sewa'])->first();
        if (!$jadwal) {
            return $this->response->setJSON(['success' => false, 'message' => 'Jadwal tidak ditemukan.']);
        }

        $tanggalLama = $jadwal['tanggal_main'];
        $jamLama = $jadwal['jam_mulai'];
        $playDateTime = strtotime($tanggalLama . ' ' . $jamLama);
        if (($playDateTime - time()) / 3600 < 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Batas waktu ubah jadwal telah habis (minimal 3 jam sebelum jadwal asli dimulai).']);
        }

        if ($tanggalBaru < date('Y-m-d')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal baru tidak boleh di masa lalu.']);
        }

        $durasiLama = (int)substr($jadwal['jam_selesai'], 0, 2) - (int)substr($jadwal['jam_mulai'], 0, 2);
        if ($durasiLama <= 0) $durasiLama = 1;

        $durasiBaru = $durasiBaruInput ? (int)$durasiBaruInput : $durasiLama;
        if ($durasiBaru <= 0) $durasiBaru = 1;

        $jamMulaiHour = (int) substr($jamMulaiBaru, 0, 2);
        $jamSelesaiBaru = str_pad($jamMulaiHour + $durasiBaru, 2, '0', STR_PAD_LEFT) . ':00';

        $allSlots = $jadwalModel->getBookedSlotsForDate($tanggalBaru);
        $occupiedHours = [];
        foreach ($allSlots as $s) {
            if ((string)$s['id_lapang'] === (string)$jadwal['id_lapang'] && (string)$s['id_sewa'] !== (string)$booking['id_sewa']) {
                $sStart = (int) substr($s['jam_mulai'], 0, 2);
                $sEnd = (int) substr($s['jam_selesai'], 0, 2);
                for ($h = $sStart; $h < $sEnd; $h++) {
                    $occupiedHours[] = $h;
                }
            }
        }

        for ($h = $jamMulaiHour; $h < $jamMulaiHour + $durasiBaru; $h++) {
            if (in_array($h, $occupiedHours)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Maaf, jam yang Anda pilih sudah terisi. Silakan pilih jam lain.']);
            }
        }

        // Calculate old price for this jadwal
        $tarifModel = new TarifModel();
        function getHarga($tarifModel, $id_lapang, $tanggal, $jamStart, $durasi) {
            $dow = date('w', strtotime($tanggal));
            $kategoriHari = ($dow == 0 || $dow == 6) ? 'Weekend' : 'Weekday';
            $tarifs = $tarifModel->where('id_lapang', $id_lapang)->where('hari', $kategoriHari)->findAll();
            if (empty($tarifs)) $tarifs = $tarifModel->where('id_lapang', $id_lapang)->findAll();
            
            $total = 0;
            for ($h = $jamStart; $h < $jamStart + $durasi; $h++) {
                $slotTime = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                $harga = 0;
                foreach ($tarifs as $t) {
                    if ($slotTime >= substr($t['jam_mulai'], 0, 5) && $slotTime < substr($t['jam_selesai'], 0, 5)) {
                        $harga = (int) $t['harga_umum']; break;
                    }
                }
                if ($harga === 0 && !empty($tarifs)) $harga = (int) $tarifs[0]['harga_umum'];
                $total += $harga;
            }
            return $total;
        }

        $oldPrice = getHarga($tarifModel, $jadwal['id_lapang'], $jadwal['tanggal_main'], (int)substr($jadwal['jam_mulai'], 0, 2), $durasiLama);
        $newPrice = getHarga($tarifModel, $jadwal['id_lapang'], $tanggalBaru, $jamMulaiHour, $durasiBaru);

        $priceDiff = $newPrice - $oldPrice;
        $newTotal = (int)$booking['total_bayar'] + $priceDiff;

        $durasiDiff = $durasiBaru - $durasiLama;
        $newDurasiJam = (isset($booking['durasi_jam']) ? (int)$booking['durasi_jam'] : 0) + $durasiDiff;

        $bookingModel->update($booking['id_sewa'], [
            'total_bayar' => $newTotal,
            'durasi_jam' => $newDurasiJam,
        ]);

        $jadwalModel->update($jadwal['id_jadwal'], [
            'tanggal_main' => $tanggalBaru,
            'jam_mulai' => $jamMulaiBaru,
            'jam_selesai' => $jamSelesaiBaru,
        ]);

        $this->_sendEmailToAdminUbahJadwal(
            $booking['kode_sewa'], 
            $booking['nama_penyewa'], 
            $jadwal['tanggal_main'] . ' ' . $jadwal['jam_mulai'], 
            $tanggalBaru . ' ' . $jamMulaiBaru
        );

        // Get paid amount
        $pembayaranModel = new \App\Models\PembayaranModel();
        $pembayaran = $pembayaranModel->where('id_sewa', $booking['id_sewa'])->findAll();
        $sudahDibayar = 0;
        foreach($pembayaran as $p) {
            if ($p['status_pembayaran'] === 'Sukses') {
                $sudahDibayar += (int)$p['jumlah_bayar'];
            }
        }
        $sisaBayar = $newTotal - $sudahDibayar;
        if ($sisaBayar < 0) $sisaBayar = 0;

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Jadwal berhasil diubah!',
            'data' => [
                'tanggal_baru' => $tanggalBaru,
                'jam_mulai' => $jamMulaiBaru,
                'jam_selesai' => $jamSelesaiBaru,
                'total_bayar' => $newTotal,
                'sudah_dibayar' => $sudahDibayar,
                'sisa_bayar' => $sisaBayar,
                'price_diff' => $priceDiff
            ],
        ]);
    }

    /**
     * GET /api/getJadwalMembership?id_sewa=123
     * Returns JSON array of membership session schedules.
     */
    public function getJadwalMembership()
    {
        $idSewa = $this->request->getGet('id_sewa');
        if (!$idSewa) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID sewa wajib diisi.']);
        }

        $jadwalModel = new JadwalModel();
        $jadwals = $jadwalModel->getByIdSewa((int) $idSewa);

        return $this->response->setJSON([
            'success' => true,
            'jadwals' => $jadwals,
        ]);
    }
    /**
     * GET /api/getPembayaran?id_sewa=123
     * Returns JSON array of payment records for a booking.
     */
    public function getPembayaran()
    {
        $idSewa = $this->request->getGet('id_sewa');
        if (!$idSewa) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID sewa wajib diisi.']);
        }

        $pembayaranModel = new PembayaranModel();
        $pembayarans = $pembayaranModel->where('id_sewa', (int) $idSewa)
            ->orderBy('waktu_pembayaran', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'pembayarans' => $pembayarans,
        ]);
    }

    private function _sendEmailToAdminUbahJadwal($kode_sewa, $nama_penyewa, $jadwal_lama, $jadwal_baru)
    {
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('role', 'Admin')->findAll();
        $emails = [];
        foreach ($admins as $admin) {
            if (!empty($admin['email'])) {
                $emails[] = $admin['email'];
            }
        }

        if (!empty($emails)) {
            $emailService = \Config\Services::email();
            $emailService->setTo($emails);
            $emailService->setSubject('Perubahan Jadwal Booking: ' . $kode_sewa);
            
            $data = [
                'kode_sewa' => $kode_sewa,
                'nama_penyewa' => $nama_penyewa,
                'jadwal_lama' => $jadwal_lama,
                'jadwal_baru' => $jadwal_baru,
            ];
            
            $message = view('email/admin_schedule_changed', $data, ['debug' => false]);
            $emailService->setMessage($message);
            $emailService->send();
        }
    }

}
