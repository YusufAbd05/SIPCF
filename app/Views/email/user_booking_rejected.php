<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Ditolak - Carrera Futsal</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #dc2626; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .reason-box { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; margin: 20px 0; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesanan Ditolak</h2>
        </div>
        <div class="content">
            <p>Halo <?= esc($nama_penyewa) ?>,</p>
            <p>Mohon maaf, pesanan lapangan Anda (Kode: <strong><?= esc($kode_sewa) ?></strong>) telah <strong>Ditolak</strong> oleh admin kami.</p>
            
            <?php if (!empty($alasan_penolakan)): ?>
            <div class="reason-box">
                <strong>Alasan Penolakan:</strong><br>
                <?= nl2br(esc($alasan_penolakan)) ?>
            </div>
            <?php endif; ?>

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

            <p style="margin-top:20px;">Jika Anda sudah melakukan pembayaran (DP/Full), admin kami akan segera menghubungi Anda untuk proses pengembalian dana (Refund), atau Anda dapat membalas email ini untuk informasi lebih lanjut.</p>
            
            <p>Terima kasih atas pengertiannya,<br><strong>Tim Carrera Futsal</strong></p>
        </div>
    </div>
</body>
</html>
