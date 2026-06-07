<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesanan Booking Baru Masuk</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #059669; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        table th { background-color: #f1f5f9; }
        .btn { display: inline-block; background: #059669; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesanan Booking Baru</h2>
        </div>
        <div class="content">
            <p>Halo Admin,</p>
            <p>Ada pesanan booking baru yang masuk dan sedang <strong>Menunggu Verifikasi</strong>. Berikut adalah rincian pesanan:</p>
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
                    <th>No HP / WhatsApp</th>
                    <td><?= esc($no_hp) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= esc($email_penyewa) ?></td>
                </tr>
                <tr>
                    <th>Tipe Sewa</th>
                    <td><?= esc($tipe_sewa) ?></td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>Rp <?= number_format($total_bayar, 0, ',', '.') ?></td>
                </tr>
            </table>

            <h3 style="margin-top: 20px;">Rincian Jadwal</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lapangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jadwals)): ?>
                        <?php foreach($jadwals as $j): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($j['tanggal_main'])) ?></td>
                            <td><?= substr($j['jam_mulai'], 0, 5) ?> - <?= substr($j['jam_selesai'], 0, 5) ?></td>
                            <td><?= esc($j['nama_lapangan']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;">Jadwal belum tersedia.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <p style="margin-top:20px;">Silakan login ke sistem untuk melakukan verifikasi pembayaran dan mengkonfirmasi pesanan ini.</p>
            <center>
                <a href="<?= base_url('/login') ?>" class="btn">Login ke Dashboard Admin</a>
            </center>
        </div>
    </div>
</body>
</html>
