# Alur Kelola Tarif — SIPCF (Carrera Futsal)

Dokumen ini menjelaskan alur lengkap pengelolaan tarif harga lapangan dari sudut pandang **Admin** di halaman `admin/tarif.html`.

---

## Gambaran Umum

Halaman **Kelola Tarif** adalah halaman terpusat untuk mengatur **harga sewa lapang secara dinamis** berdasarkan:
- Nama lapang / kategori lapang
- Kategori hari (Weekday / Weekend / Semua Hari)
- Rentang jam berlaku
- Tipe pengguna (Umum / Member)


---

## Sistem Tarif Dinamis

Tarif dihitung berdasarkan **kombinasi** dari:

| Parameter | Pilihan |
|---|---|
| Lapang | Semua Lapangan / Kategori / Lapang Spesifik |
| Kategori Hari | Weekday (Sen-Jum) / Weekend (Sab-Min) / Semua Hari |
| Rentang Jam | Jam Mulai — Jam Selesai |
| Harga Umum | Per jam (Rp) |
| Harga Member | Per jam (Rp) — lebih murah dari harga umum |

---

## Tampilan Halaman Utama

### Kolom Tabel Tarif

| Kolom | Keterangan |
|---|---|
| Nama & Lapangan | Nama tarif + lapang yang berlaku |
| Kategori Hari | Badge Weekday / Weekend / Semua Hari |
| Rentang Jam | Jam berlakunya tarif ini |
| Harga Umum | Harga per jam untuk pelanggan umum |
| Harga Member | Harga per jam untuk pelanggan member (warna hijau) |
| Aksi | Tombol **Edit** (✏️) dan **Hapus** (🗑️) |

### Contoh Data Tarif:

| Nama Tarif | Lapang | Hari | Jam | Umum | Member |
|---|---|---|---|---|---|
| Pagi Weekday Futsal | Futsal A, Futsal B | Senin–Jumat | 08:00–16:00 | Rp 100.000 | Rp 80.000 |
| Malam Weekday Futsal | Futsal A, Futsal B | Senin–Jumat | 16:00–24:00 | Rp 150.000 | Rp 120.000 |
| Weekend Futsal All Day | Futsal A, Futsal B | Sabtu–Minggu | 07:00–24:00 | Rp 150.000 | Rp 120.000 |
| Reguler Badminton | Badminton 1 | Semua Hari | 08:00–22:00 | Rp 50.000 | Rp 40.000 |

---

## Alur 1 — Tambah Tarif Baru

```
[Admin klik "Tambah Tarif"]
        │
        ▼
[Modal "Setelan Harga Dinamis" terbuka]
        │
        ├── Nama Tarif
        │   (contoh: "Pagi Weekday", "Malam Weekend Futsal")
        │
        ├── Berlaku Untuk (Lapangan):
        │   • Semua Lapangan
        │   • Kategori: Futsal (Semua)
        │   • Kategori: Badminton (Semua)
        │   • Lapang spesifik (ex: Lapang Futsal A)
        │
        ├── Kategori Hari:
        │   • Senin – Jumat (Weekday)
        │   • Sabtu – Minggu (Weekend)
        │   • Semua Hari
        │
        ├── Rentang Jam:
        │   - Jam Mulai (time input)
        │   - Jam Selesai (time input)
        │
        ├── Harga Umum / Jam (Rp)
        │
        └── Harga Member / Jam (Rp)
                │
                ▼
        [Klik "Simpan Aturan"]
                │
                ▼
        ✅ Tarif baru muncul di tabel utama
```

---

## Alur 2 — Edit Tarif

Digunakan untuk mengubah aturan tarif yang sudah ada.

```
[Admin klik tombol ✏️ Edit pada baris tarif]
        │
        ▼
[Modal "Setelan Harga Dinamis" terbuka]
(Data tarif otomatis terisi: nama, lapang, hari, jam, harga)
        │
        ▼
[Admin ubah field yang perlu diperbarui]
        │
        ▼
[Klik "Simpan Aturan"]
        │
        ▼
✅ Tarif diperbarui di tabel
```

> [!NOTE]
> Modal yang digunakan untuk Tambah dan Edit adalah modal yang **sama** (`#tambahTarifModal`).  
> Saat Edit, form akan terisi otomatis dengan data tarif yang dipilih.

---

## Alur 3 — Hapus Tarif

```
[Admin klik tombol 🗑️ Hapus pada baris tarif]
        │
        ▼
✅ Tarif langsung dihapus dari daftar
```

> [!WARNING]
> Hapus tarif bersifat **langsung** tanpa konfirmasi tambahan di halaman ini.  
> Pertimbangkan untuk menambahkan dialog konfirmasi agar tidak terjadi penghapusan tidak sengaja.

---

## Perbedaan: Tarif di `tarif.html` vs `lapang.html`

| Aspek | `tarif.html` | `lapang.html` → Modal Kelola Tarif |
|---|---|---|
| Cakupan | **Semua lapang** dalam satu tabel | **Per lapang** yang diklik |
| Pilih Lapang | Bisa pilih semua / kategori / spesifik | Otomatis terkunci ke lapang tersebut |
| Kolom Lapangan | Tampil di tabel | Tidak perlu (sudah kontekstual) |
| Aksi | Edit + Hapus | Tambah + Hapus |
| Navigasi | Halaman tersendiri | Modal dalam halaman Kelola Lapang |

---

## Diagram Alur Lengkap

```
[Halaman Kelola Tarif]
        │
        ├── [Tambah Tarif] ─────────────────────────────────────────┐
        │       Modal:                                                │
        │       Nama → Pilih Lapang → Kategori Hari                  │
        │       → Jam → Harga Umum → Harga Member                    │
        │       → Simpan → ✅ Tarif baru di tabel                    │
        │                                                             │
        ├── [Edit Tarif ✏️] ─────────────────────────────────────────►│
        │       Modal terisi otomatis → Ubah data → Simpan           │
        │       → ✅ Tarif diperbarui                                 │
        │                                                             │
        └── [Hapus Tarif 🗑️] ─────────────────────────────────────────►│
                Langsung dihapus → ✅ Tarif hilang dari daftar         │
                                                                       │
                                               (Tarif digunakan oleh sistem booking
                                                untuk kalkulasi harga otomatis)
```

---

## Catatan Pengembangan

> [!NOTE]
> - Data tarif disimpan di tabel `t_lapang_tarif` dengan kolom:
>   `id_tarif`, `id_lapang`, `nama_tarif`, `hari`, `jam_mulai`, `jam_selesai`, `harga_umum`, `harga_member`.
> - Satu lapang dapat memiliki **banyak blok tarif** yang saling tidak tumpang tindih.
> - Saat booking, sistem akan **otomatis memilih tarif** yang sesuai berdasarkan:
>   hari booking × jam slot yang dipilih × status keanggotaan penyewa.
> - Harga Member selalu lebih rendah dari Harga Umum.
> - Tarif dengan cakupan "Semua Lapangan" berlaku untuk seluruh lapang yang terdaftar.
