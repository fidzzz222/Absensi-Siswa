<p align="center">
  <img src="public/images/logo.png" alt="Logo SMKN 1 Kota Bekasi" width="100">
</p>

<h1 align="center">Si Hadir - Sistem Presensi & Kedisiplinan Siswa</h1>

<p align="center">
  <strong>SMK Negeri 1 Kota Bekasi</strong><br>
  Aplikasi manajemen presensi mata pelajaran, rekapitulasi kehadiran, dan pencatatan kedisiplinan siswa berbasis web modern dengan Multi-Role Access Control.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5.3">
  <img src="https://img.shields.io/badge/MySQL-XAMPP-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## 📋 Fitur Utama

### 1. Multi-Role Authentication (5 Peran Pengguna)
- **Guru Mapel**: Input absensi jam pelajaran siswa secara berkala, pantau statistik kehadiran harian, dan akses rekap lengkap.
- **Siswa**: Portal mandiri melihat persentase kehadiran pribadi, total jam terdata, riwayat kehadiran per mapel, serta catatan kedisiplinan.
- **Sekretaris Kelas**: Membantu guru mencatat presensi harian rekan sekelas dan memantau rekap absensi kelas.
- **Guru BK (Bimbingan Konseling)**: Deteksi dini siswa yang sering alfa/bolos, rekap akumulasi pelanggaran siswa, dan pencatatan bimbingan.
- **Guru Piket**: Monitoring kehadiran harian seluruh rombel sekolah, pencatatan keterlambatan gerbang, dan rekap siswa tidak hadir.

### 2. Input Absensi Cepat & Interaktif
- Tombol aksi massal 1-klik: **Semua Masuk**, **Semua Izin**, **Semua Sakit**, dan **Semua Alfa**.
- Dilengkapi mekanisme `updateOrCreate` untuk mencegah duplikasi data serta memudahkan koreksi absensi.

### 3. Rekap & Riwayat Presensi Terpadu
- Filter pencarian komprehensif berdasarkan **Kelas**, **Mata Pelajaran**, **Rentang Tanggal**, dan **Status Kehadiran**.
- Dilengkapi paginasi data rapi dan responsif.

### 4. Manajemen Pelanggaran & Tata Tertib Siswa
- Pencatatan tanggal kasus, jenis pelanggaran, poin kedisiplinan, catatan keterangan, dan riwayat tindakan penanganan.

---

## 🔑 Akun Demo Pengujian

Semua akun default menggunakan password: **`123456`**

| Role | Email | Akses & Wewenang |
| :--- | :--- | :--- |
| **Guru Mapel** | `guru@smkn1kotabekasi.sch.id` | Input absensi kelas, lihat rekapitulasi, dashboard guru |
| **Siswa** | `siswa@smkn1kotabekasi.sch.id` | Portal pribadi kehadiran (persentase & rekap) & status pelanggaran |
| **Sekretaris** | `sekretaris@smkn1kotabekasi.sch.id` | Input absensi rekan sekelas, rekap presensi kelas |
| **Guru BK** | `bk@smkn1kotabekasi.sch.id` | Pantau siswa alfa tinggi, catat & tangani pelanggaran |
| **Guru Piket** | `piket@smkn1kotabekasi.sch.id` | Rekap kehadiran sekolah hari ini, catat siswa terlambat |

*(Tersedia tombol **Quick Demo Login 1-Klik** di halaman login untuk kemudahan pengujian).*

---

## 🚀 Panduan Instalasi & Menjalankan Project

### Prasyarat
- PHP >= 8.2 (ekstensi: pdo_mysql, mbstring, openssl, gd)
- Composer
- MySQL Server (XAMPP / Laragon / MariaDB)

### Langkah-langkah
1. **Clone Repository**
   ```bash
   git clone https://github.com/USERNAME/REPO_NAME.git
   cd REPO_NAME
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE="projek si absen"
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi & Seed Database**
   Buat database bernama `projek si absen` di phpMyAdmin, kemudian jalankan:
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser pada alamat: **`http://127.0.0.1:8000`**

---

## 🧪 Menjalankan Automated Testing

Proyek ini telah dilengkapi dengan suite pengujian otomatis fitur end-to-end:
```bash
php artisan test
```

---

## 👨‍💻 Lisensi
Open-source di bawah lisensi [MIT License](LICENSE).
