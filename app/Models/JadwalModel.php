<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table         = 't_jadwal';
    protected $primaryKey    = 'id_jadwal';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_sewa',
        'id_lapang',
        'sesi_ke',
        'tanggal_main',
        'jam_mulai',
        'jam_selesai',
        'status_sesi',
    ];

    /**
     * Get all sessions for a given booking ID.
     */
    public function getByIdSewa(int $idSewa): array
    {
        return $this->where('id_sewa', $idSewa)
                    ->orderBy('sesi_ke', 'ASC')
                    ->findAll();
    }

    /**
     * Get all booked slots for a given date (all types: Per Jam, Harian, Membership).
     * Returns array of ['id_sewa' => ..., 'id_lapang' => ..., 'jam_mulai' => ..., 'jam_selesai' => ...].
     * Now reads id_lapang directly from t_jadwal (supports multi-lapang per booking).
     */
    public function getBookedSlotsForDate(string $tanggal, ?int $exclude_idSewa = null): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('t_jadwal jm')
            ->select('jm.id_sewa, jm.id_lapang, jm.jam_mulai, jm.jam_selesai')
            ->join('t_sewa_lapangan s', 's.id_sewa = jm.id_sewa')
            ->where('jm.tanggal_main', $tanggal)
            ->where('jm.status_sesi', 'Terjadwal')
            ->whereNotIn('s.status_pesanan', ['Ditolak', 'Dibatalkan']);
            
        if ($exclude_idSewa !== null) {
            $builder->where('jm.id_sewa !=', $exclude_idSewa);
        }
            
        return $builder->get()->getResultArray();
    }

    /**
     * Hitung jumlah sesi bermain hari ini (untuk dashboard Admin).
     */
    public function countSewaHariIni(string $tanggal): int
    {
        $db = \Config\Database::connect();
        return $db->table('t_jadwal j')
            ->join('t_sewa_lapangan s', 's.id_sewa = j.id_sewa')
            ->where('j.tanggal_main', $tanggal)
            ->where('j.status_sesi', 'Terjadwal')
            ->whereNotIn('s.status_pesanan', ['Ditolak', 'Dibatalkan'])
            ->countAllResults();
    }

    /**
     * Ambil jadwal hari ini beserta info penyewa & lapangan (untuk dashboard Admin).
     */
    public function getJadwalHariIni(string $tanggal): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_jadwal j')
            ->select('j.jam_mulai, j.jam_selesai, s.nama_penyewa, l.nama_lapangan, s.status_pesanan')
            ->join('t_sewa_lapangan s', 's.id_sewa = j.id_sewa')
            ->join('t_lapang l', 'l.id_lapang = j.id_lapang', 'left')
            ->where('j.tanggal_main', $tanggal)
            ->where('j.status_sesi', 'Terjadwal')
            ->whereNotIn('s.status_pesanan', ['Ditolak', 'Dibatalkan'])
            ->orderBy('j.jam_mulai', 'ASC')
            ->get()->getResultArray();
    }
}
