<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Perubahan Jadwal Booking</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #ea580c; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        table th { background-color: #f1f5f9; }
        .btn { display: inline-block; background: #ea580c; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pemberitahuan Perubahan Jadwal</h2>
        </div>
        <div class="content">
            <p>Halo Admin,</p>
            <p>Terdapat penyewa yang telah <strong>mengubah jadwal bermainnya melalui sistem</strong>. Berikut adalah rincian perubahannya:</p>
            <table>
                <tr>
                    <th>Kode Booking</th>
                    <td><?= esc($kode_sewa) ?></td>
                </tr>
                <tr>
                    <th>Nama Penyewa</th>
                    <td><?= esc($nama_penyewa) ?></td>
                </tr>
                <tr>
                    <th>Jadwal Lama</th>
                    <td><?= esc($jadwal_lama) ?></td>
                </tr>
                <tr>
                    <th>Jadwal Baru</th>
                    <td><strong><?= esc($jadwal_baru) ?></strong></td>
                </tr>
            </table>
            <p>Perubahan ini telah tersimpan secara otomatis di sistem. Silakan periksa dashboard Anda untuk melihat jadwal lapangan terkini.</p>
            <center>
                <a href="<?= base_url('/login') ?>" class="btn">Login ke Dashboard Admin</a>
            </center>
        </div>
    </div>
</body>
</html>
