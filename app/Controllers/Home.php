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
            $lapangData = $lapangModel->find($idLapang);
            $jumlahHari = max(1, (int) $this->request->getPost('jumlah_hari'));

            // Determine operating hours from lapang data
            $opJamBuka = 8;
            $opJamTutup = 20;
            if ($lapangData) {
                $dow = date('w', strtotime($tanggalMain));
                $isWeekend = ($dow == 0 || $dow == 6);
                $opJamBuka = (int) ($isWeekend ? $lapangData['jam_buka_weekend'] : $lapangData['jam_buka_weekday']);
                $opJamTutup = (int) ($isWeekend ? $lapangData['jam_tutup_weekend'] : $lapangData['jam_tutup_weekday']);
                if ($opJamTutup <= $opJamBuka)
                    $opJamTutup = 24;
            }

            $jamMulai = str_pad($opJamBuka, 2, '0', STR_PAD_LEFT) . ':00';
            $jamSelesai = str_pad($opJamTutup, 2, '0', STR_PAD_LEFT) . ':00';
            $durasiPerHari = $opJamTutup - $opJamBuka;

            // Generate consecutive dates
            $dates = [];
            $baseDate = new \DateTime($tanggalMain);
            for ($i = 0; $i < $jumlahHari; $i++) {
                $date = clone $baseDate;
                $date->modify("+{$i} days");
                $dates[] = $date->format('Y-m-d');
            }

            // Validate slot availability for ALL dates via t_jadwal
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

                for ($h = $opJamBuka; $h < $opJamTutup; $h++) {
                    if (in_array($h, $occupied)) {
                        $readableDate = date('d M Y', strtotime($date));
                        return redirect()->back()->withInput()
                            ->with('error', "Maaf, lapangan sudah terisi pada tanggal {$readableDate}. Silakan pilih tanggal lain.");
                    }
                }
            }

            // Generate kode (HR prefix for harian)
            $dateStr = date('Ymd');
            $countToday = $bookingModel->like('kode_sewa', "HR-{$dateStr}-")->countAllResults();
            $kodeSewa = "HR-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

            // Create 1 booking record
            $dataBooking = [
                'kode_sewa' => $kodeSewa,
                'id_lapang' => $idLapang,
                'nama_penyewa' => $this->request->getPost('nama'),
                'no_hp_penyewa' => $this->request->getPost('whatsapp'),
                'tipe_pesanan' => 'Online',
                'tipe_sewa' => 'Harian',
                'durasi_jam' => $durasiPerHari,
                'total_bayar' => $totalBayar,
                'status_pesanan' => 'Menunggu Verifikasi',
            ];

            $bookingModel->insert($dataBooking);
            $idSewa = $bookingModel->getInsertID();

            // Create N jadwal records (1 per day)
            foreach ($dates as $idx => $date) {
                // Recalculate operating hours per day (weekend/weekday may differ)
                $dow2 = date('w', strtotime($date));
                $isWe2 = ($dow2 == 0 || $dow2 == 6);
                $dayJamBuka = $opJamBuka;
                $dayJamTutup = $opJamTutup;
                if ($lapangData) {
                    $dayJamBuka = (int) ($isWe2 ? $lapangData['jam_buka_weekend'] : $lapangData['jam_buka_weekday']);
                    $dayJamTutup = (int) ($isWe2 ? $lapangData['jam_tutup_weekend'] : $lapangData['jam_tutup_weekday']);
                    if ($dayJamTutup <= $dayJamBuka)
                        $dayJamTutup = 24;
                }

                $jadwalModel->insert([
                    'id_sewa' => $idSewa,
                    'sesi_ke' => $idx + 1,
                    'tanggal_main' => $date,
                    'jam_mulai' => str_pad($dayJamBuka, 2, '0', STR_PAD_LEFT) . ':00',
                    'jam_selesai' => str_pad($dayJamTutup, 2, '0', STR_PAD_LEFT) . ':00',
                    'status_sesi' => 'Terjadwal',
                ]);
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

            return redirect()->to('/booking?success=1&kode=' . $kodeSewa)
                ->with('booking_success', true)
                ->with('kode_sewa', $kodeSewa);
        }

        // ═══════════════════════════════════════════════
        //  MODE: PER JAM (single booking + 1 jadwal record)
        // ═══════════════════════════════════════════════
        $jamSelesai = str_pad($jamMulaiHour + $durasi, 2, '0', STR_PAD_LEFT) . ':00';

        // ── Check slot availability via t_jadwal ──
        $jadwalModel = new JadwalModel();
        $allSlots = $jadwalModel->getBookedSlotsForDate($tanggalMain);

        $occupiedHours = [];
        foreach ($allSlots as $s) {
            if ((string) $s['id_lapang'] === (string) $idLapang) {
                $sStart = (int) substr($s['jam_mulai'], 0, 2);
                $sEnd = (int) substr($s['jam_selesai'], 0, 2);
                for ($h = $sStart; $h < $sEnd; $h++) {
                    $occupiedHours[] = $h;
                }
            }
        }

        for ($h = $jamMulaiHour; $h < $jamMulaiHour + $durasi; $h++) {
            if (in_array($h, $occupiedHours)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Maaf, jam yang Anda pilih sudah terisi. Silakan pilih jam lain.');
            }
        }

        // ── Generate Kode Booking ──
        $dateStr = date('Ymd');
        $countToday = $bookingModel->like('kode_sewa', "BK-{$dateStr}-")->countAllResults();
        $kodeSewa = "BK-{$dateStr}-" . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        // ── Save Booking ──
        $dataBooking = [
            'kode_sewa' => $kodeSewa,
            'id_lapang' => $idLapang,
            'nama_penyewa' => $this->request->getPost('nama'),
            'no_hp_penyewa' => $this->request->getPost('whatsapp'),
            'tipe_pesanan' => 'Online',
            'tipe_sewa' => 'Per Jam',
            'durasi_jam' => $durasi,
            'total_bayar' => $totalBayar,
            'status_pesanan' => 'Menunggu Verifikasi',
        ];

        $bookingModel->insert($dataBooking);
        $idSewa = $bookingModel->getInsertID();

        // ── Save Jadwal (1 record) ──
        $jadwalModel->insert([
            'id_sewa' => $idSewa,
            'sesi_ke' => 1,
            'tanggal_main' => $tanggalMain,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'status_sesi' => 'Terjadwal',
        ]);

        // ── Save Pembayaran ──
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

        // ── Redirect to success page ──
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

        // Get first jadwal for schedule info
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->where('id_sewa', $booking['id_sewa'])->where('sesi_ke', 1)->first();

        // Check reschedule deadline: minimum 3 hours before play time
        $tanggalMain = $jadwal['tanggal_main'] ?? date('Y-m-d');
        $jamMulai = $jadwal['jam_mulai'] ?? '00:00';
        $playDateTime = strtotime($tanggalMain . ' ' . $jamMulai);
        $now = time();
        $hoursUntilPlay = ($playDateTime - $now) / 3600;

        if ($hoursUntilPlay < 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batas waktu ubah jadwal telah habis. Minimal 3 jam sebelum jadwal bermain.'
            ]);
        }

        // Get lapang name
        $lapang = $lapangModel->find($booking['id_lapang']);
        $namaLapangan = $lapang ? $lapang['nama_lapangan'] : 'Lapangan';

        return $this->response->setJSON([
            'success' => true,
            'booking' => [
                'id_sewa' => $booking['id_sewa'],
                'kode_sewa' => $booking['kode_sewa'],
                'nama_penyewa' => $booking['nama_penyewa'],
                'id_lapang' => $booking['id_lapang'],
                'nama_lapangan' => $namaLapangan,
                'tanggal_main' => $tanggalMain,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jadwal['jam_selesai'] ?? '00:00',
                'durasi_jam' => $booking['durasi_jam'],
                'total_bayar' => $booking['total_bayar'],
                'status_pesanan' => $booking['status_pesanan'],
                'tipe_pesanan' => $booking['tipe_pesanan'],
            ],
        ]);
    }

    /**
     * POST /api/ubahJadwal
     * Reschedule a booking: update tanggal_main, jam_mulai, jam_selesai.
     * Validates slot availability and reschedule deadline.
     */
    public function processUbahJadwal()
    {
        $bookingModel = new BookingModel();

        $kodeSewa = $this->request->getPost('kode_sewa');
        $tanggalBaru = $this->request->getPost('tanggal_baru');
        $jamMulaiBaru = $this->request->getPost('jam_mulai_baru');

        // ── Basic validation ──
        if (!$kodeSewa || !$tanggalBaru || !$jamMulaiBaru) {
            return $this->response->setJSON(['success' => false, 'message' => 'Semua field wajib diisi.']);
        }

        // ── Find booking ──
        $booking = $bookingModel->where('kode_sewa', $kodeSewa)->first();
        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode booking tidak ditemukan.']);
        }

        // ── Check status ──
        $allowedStatuses = ['Menunggu', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Dikonfirmasi'];
        if (!in_array($booking['status_pesanan'], $allowedStatuses)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Booking ini tidak dapat diubah jadwalnya.'
            ]);
        }

        // ── Get current jadwal ──
        $jadwalModel = new JadwalModel();
        $jadwal = $jadwalModel->where('id_sewa', $booking['id_sewa'])->where('sesi_ke', 1)->first();

        // ── Reschedule deadline: 3 hours before original play time ──
        $tanggalLama = $jadwal['tanggal_main'] ?? date('Y-m-d');
        $jamLama = $jadwal['jam_mulai'] ?? '00:00';
        $playDateTime = strtotime($tanggalLama . ' ' . $jamLama);
        $now = time();
        if (($playDateTime - $now) / 3600 < 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Batas waktu ubah jadwal telah habis (minimal 3 jam sebelum bermain).'
            ]);
        }

        // ── Validate new date ──
        if ($tanggalBaru < date('Y-m-d')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal baru tidak boleh di masa lalu.']);
        }

        // ── Calculate new jam_selesai ──
        $durasi = (int) $booking['durasi_jam'];
        $jamMulaiHour = (int) substr($jamMulaiBaru, 0, 2);
        $jamSelesaiBaru = str_pad($jamMulaiHour + $durasi, 2, '0', STR_PAD_LEFT) . ':00';

        // ── Check slot availability via t_jadwal (exclude current booking) ──
        $allSlots = $jadwalModel->getBookedSlotsForDate($tanggalBaru);

        $occupiedHours = [];
        foreach ($allSlots as $s) {
            if ((string) $s['id_lapang'] === (string) $booking['id_lapang'] && (string) $s['id_sewa'] !== (string) $booking['id_sewa']) {
                $sStart = (int) substr($s['jam_mulai'], 0, 2);
                $sEnd = (int) substr($s['jam_selesai'], 0, 2);
                for ($h = $sStart; $h < $sEnd; $h++) {
                    $occupiedHours[] = $h;
                }
            }
        }

        for ($h = $jamMulaiHour; $h < $jamMulaiHour + $durasi; $h++) {
            if (in_array($h, $occupiedHours)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Maaf, jam yang Anda pilih sudah terisi. Silakan pilih jam lain.'
                ]);
            }
        }

        // ── Recalculate price based on new date's tariff ──
        $tarifModel = new TarifModel();
        $dow = date('w', strtotime($tanggalBaru));
        $kategoriHari = ($dow == 0 || $dow == 6) ? 'Weekend' : 'Weekday';

        $tarifs = $tarifModel
            ->where('id_lapang', $booking['id_lapang'])
            ->where('hari', $kategoriHari)
            ->findAll();

        if (empty($tarifs)) {
            $tarifs = $tarifModel
                ->where('id_lapang', $booking['id_lapang'])
                ->findAll();
        }

        // Calculate new total based on tariff slots
        $newTotal = 0;
        for ($h = $jamMulaiHour; $h < $jamMulaiHour + $durasi; $h++) {
            $slotTime = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            $harga = 0;
            foreach ($tarifs as $t) {
                $tStart = substr($t['jam_mulai'], 0, 5);
                $tEnd = substr($t['jam_selesai'], 0, 5);
                if ($slotTime >= $tStart && $slotTime < $tEnd) {
                    $harga = (int) $t['harga_umum'];
                    break;
                }
            }
            $newTotal += $harga;
        }

        // If we couldn't find tariff, keep original total
        if ($newTotal <= 0) {
            $newTotal = (int) $booking['total_bayar'];
        }

        // ── Update booking total ──
        $bookingModel->update($booking['id_sewa'], [
            'total_bayar' => $newTotal,
        ]);

        // ── Update jadwal sesi_ke=1 ──
        if ($jadwal) {
            $jadwalModel->update($jadwal['id_jadwal'], [
                'tanggal_main' => $tanggalBaru,
                'jam_mulai' => $jamMulaiBaru,
                'jam_selesai' => $jamSelesaiBaru,
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Jadwal booking berhasil diubah!',
            'data' => [
                'kode_sewa' => $kodeSewa,
                'tanggal_baru' => $tanggalBaru,
                'jam_mulai' => $jamMulaiBaru,
                'jam_selesai' => $jamSelesaiBaru,
                'total_bayar' => $newTotal,
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

}

