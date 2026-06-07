<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Dikonfirmasi - Carrera Futsal</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #059669; color: #fff; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .kode-box { background: #ecfdf5; border: 2px dashed #059669; color: #059669; font-size: 24px; font-weight: bold; text-align: center; padding: 15px; margin: 20px 0; border-radius: 8px; letter-spacing: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        table th { background-color: #f1f5f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesanan Dikonfirmasi</h2>
        </div>
        <div class="content">
            <p>Halo <?= esc($nama_penyewa) ?>,</p>
            <p>Kabar baik! Pesanan lapangan Anda telah <strong>Dikonfirmasi</strong> oleh admin kami.</p>
            <p>Gunakan Kode Booking di bawah ini saat Anda datang ke lokasi untuk bermain:</p>
            
            <div class="kode-box">
                <?= esc($kode_sewa) ?>
            </div>

            <p><strong>Rincian Pesanan:</strong></p>
            <table>
                <tr>
                    <th>Tipe Sewa</th>
                    <td><?= esc($tipe_sewa) ?></td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td><?= esc($durasi_jam) ?> Jam</td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>Rp <?= number_format($total_bayar, 0, ',', '.') ?></td>
                </tr>
            </table>

            <h3 style="margin-top: 20px;">Jadwal Bermain</h3>
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
            
            <p style="margin-top:20px;">Harap datang tepat waktu sesuai dengan jadwal yang telah Anda tentukan. Jika terdapat pertanyaan, Anda dapat membalas email ini atau menghubungi WhatsApp admin kami.</p>
            <p>Terima kasih,<br><strong>Tim Carrera Futsal</strong></p>
        </div>
    </div>
</body>
</html>
