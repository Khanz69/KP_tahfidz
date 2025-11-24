# Sistem Monitoring Data Tahfidz

Sistem monitoring data tahfidz untuk pesantren yang dibangun menggunakan CodeIgniter 4 dengan tampilan modern menggunakan Bootstrap 5.

## Fitur Utama

### 📊 Dashboard
- Statistik lengkap data santri, hafalan, dan laporan
- Grafik perkembangan hafalan 6 bulan terakhir
- Chart distribusi laporan
- Riwayat hafalan terbaru
- Log import data

### 👥 Manajemen Santri
- CRUD data santri lengkap
- Informasi kamar, kelas, dan angkatan
- Statistik hafalan per santri
- Detail riwayat hafalan santri

### 📖 Manajemen Hafalan
- CRUD data hafalan
- Filter berdasarkan tanggal, status, dan santri
- Informasi juz, halaman, dan surat
- Status lulus/tidak lulus dengan keterangan

### 📋 Manajemen Laporan
- CRUD laporan hafalan
- Jenis laporan: mingguan, bulanan, semesteran
- Filter berdasarkan jenis laporan
- Fitur print laporan

### 📤 Export Data
- Export data santri, hafalan, dan laporan
- Format CSV dan Excel
- Preview data sebelum export

## Struktur Database

### Tabel `santri`
- `santri_id` (Primary Key)
- `nama_santri`
- `kamar`
- `kelas`
- `angkatan`
- `tanggal_masuk`
- `created_at`

### Tabel `hafalan`
- `hafalan_id` (Primary Key)
- `santri_id` (Foreign Key)
- `juz`
- `halaman`
- `surat`
- `tanggal_setor`
- `status` (lulus/tidak_lulus)
- `keterangan`
- `created_at`

### Tabel `laporan`
- `laporan_id` (Primary Key)
- `hafalan_id` (Foreign Key)
- `jenis_laporan` (mingguan/bulanan/semesteran)
- `tanggal_laporan`
- `created_at`

### Tabel `user`
- `user_id` (Primary Key)
- `username`
- `password` (hashed)
- `nama`
- `role` (tamir/kepala_tahfizh)
- `created_at`

### Tabel `log_import`
- `id_log` (Primary Key)
- `user_id` (Foreign Key)
- `jumlah_data`
- `tanggal_import`
- `sumber_file`

## Instalasi

1. **Clone atau download project**
   ```bash
   git clone [repository-url]
   cd mamak
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Database**
   - Buat database MySQL dengan nama `tahfidz`
   - Import file SQL yang sudah disediakan
   - Pastikan konfigurasi database di `app/Config/Database.php` sudah benar

4. **Konfigurasi Environment**
   - Copy file `.env.example` menjadi `.env`
   - Sesuaikan konfigurasi sesuai kebutuhan

5. **Jalankan Server**
   ```bash
   php spark serve
   ```

6. **Akses Aplikasi**
   - Buka browser dan akses `http://localhost:8080`

## Struktur File

```
app/
├── Controllers/
│   ├── Dashboard.php      # Controller dashboard
│   ├── Santri.php         # Controller manajemen santri
│   ├── Hafalan.php        # Controller manajemen hafalan
│   └── Laporan.php        # Controller manajemen laporan
├── Models/
│   ├── SantriModel.php    # Model data santri
│   ├── HafalanModel.php   # Model data hafalan
│   ├── LaporanModel.php   # Model data laporan
│   ├── UserModel.php      # Model data user
│   └── LogImportModel.php # Model log import
├── Views/
│   ├── layouts/
│   │   └── main.php       # Layout utama
│   ├── dashboard/
│   │   ├── index.php      # Halaman dashboard
│   │   └── export.php     # Halaman export
│   ├── santri/
│   │   ├── index.php      # Daftar santri
│   │   ├── detail.php     # Detail santri
│   │   ├── create.php     # Form tambah santri
│   │   └── edit.php       # Form edit santri
│   ├── hafalan/
│   │   ├── index.php      # Daftar hafalan
│   │   ├── create.php     # Form tambah hafalan
│   │   └── edit.php       # Form edit hafalan
│   └── laporan/
│       ├── index.php      # Daftar laporan
│       ├── create.php     # Form tambah laporan
│       ├── edit.php       # Form edit laporan
│       └── print.php      # Halaman print laporan
└── Config/
    ├── Database.php       # Konfigurasi database
    └── Routes.php         # Konfigurasi routing
```

## Teknologi yang Digunakan

- **Backend**: CodeIgniter 4
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL
- **Charts**: Chart.js
- **Tables**: DataTables
- **Icons**: Bootstrap Icons

## Fitur Keamanan

- Password hashing menggunakan PHP password_hash()
- CSRF protection pada form
- Input validation dan sanitization
- SQL injection protection melalui Query Builder

## Cara Penggunaan

### 1. Dashboard
- Akses halaman utama untuk melihat statistik keseluruhan
- Monitor perkembangan hafalan santri
- Lihat aktivitas terbaru

### 2. Manajemen Santri
- Tambah data santri baru
- Edit informasi santri
- Lihat detail dan statistik hafalan per santri
- Hapus data santri (jika diperlukan)

### 3. Manajemen Hafalan
- Input hafalan baru dengan detail juz, halaman, surat
- Update status hafalan (lulus/tidak lulus)
- Filter hafalan berdasarkan kriteria tertentu
- Edit atau hapus data hafalan

### 4. Manajemen Laporan
- Buat laporan berdasarkan data hafalan
- Kategorikan laporan (mingguan/bulanan/semesteran)
- Print laporan untuk dokumentasi
- Filter laporan berdasarkan jenis

### 5. Export Data
- Export data dalam format CSV atau Excel
- Pilih data yang ingin diekspor
- Download file hasil export

## Kontribusi

Untuk berkontribusi pada project ini:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Project ini menggunakan lisensi MIT. Lihat file LICENSE untuk detail lebih lanjut.

## Support

Jika mengalami masalah atau memiliki pertanyaan, silakan buat issue di repository atau hubungi developer.

---

**Sistem Monitoring Data Tahfidz** - Dibuat dengan ❤️ untuk kemajuan pendidikan Islam
