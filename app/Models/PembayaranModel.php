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
}
