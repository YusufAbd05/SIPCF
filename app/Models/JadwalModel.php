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
     */
    public function getBookedSlotsForDate(string $tanggal): array
    {
        $db = \Config\Database::connect();
        return $db->table('t_jadwal jm')
            ->select('jm.id_sewa, s.id_lapang, jm.jam_mulai, jm.jam_selesai')
            ->join('t_sewa_lapangan s', 's.id_sewa = jm.id_sewa')
            ->where('jm.tanggal_main', $tanggal)
            ->where('jm.status_sesi', 'Terjadwal')
            ->whereNotIn('s.status_pesanan', ['Ditolak', 'Dibatalkan'])
            ->get()
            ->getResultArray();
    }
}
