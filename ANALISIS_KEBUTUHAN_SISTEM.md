# ANALISIS IMPLEMENTASI KEBUTUHAN SISTEM (ALAT, BAHAN, & BRAINWARE)
## SISTEM INFORMASI PRESENSI & KEDISIPLINAN SISWA (SI-HADIR)
### SMK NEGERI 1 KOTA BEKASI

Dokumen ini memuat analisis spesifikasi kebutuhan implementasi proyek yang terdiri dari **Perangkat Keras (*Hardware*)**, **Perangkat Lunak (*Software*)**, **Bahan (*Data & Aset Digital*)**, serta **Perangkat Pikir (*Brainware*)** yang disesuaikan secara presisi dengan arsitektur teknis aplikasi Si-Hadir.

---

### A. Tabel Kebutuhan Alat, Bahan, dan Brainware

| Kategori | Komponen / Nama Alat | Spesifikasi / Fungsi / Keterangan |
| :--- | :--- | :--- |
| **Perangkat Keras (*Hardware*)** | **Laptop / Komputer PC Pengembang** | Processor Intel Core i5 / AMD Ryzen 5, RAM 8GB DDR4, Storage 256GB/512GB SSD. Digunakan sebagai workstation utama dalam penulisan kode sumber, kompilasi aset, dan pengujian lokal. |
| | **Server Cloud VPS (Lingkungan Produksi)** | KVM VPS dengan RAM 4GB, 2 Core vCPU, 50GB NVMe SSD, Bandwidth Unlimited. Bertugas melayani *request concurrent* dari 36+ rombel kelas secara bersamaan pada jam sibuk. |
| | **Perangkat Klien (PC / Laptop / Smartphone)** | Perangkat milik Guru, Siswa, Guru BK, dan Petugas Piket dengan layar responsif untuk mengakses web portal tanpa perlu instalasi aplikasi khusus. |
| | **Perangkat Input (Mouse & Keyboard)** | Memudahkan navigasi kursor, akselerasi coding, serta input data administratif sekolah. |
| | **Koneksi Jaringan Internet / Wi-Fi** | Akses internet minimal kecepatan 20 Mbps untuk pengunggahan aset, sinkronisasi repository Git, serta konektivitas database cloud secara realtime. |
| **Perangkat Lunak (*Software*)** | **Sistem Operasi** | Windows 11 Pro 64-bit (Lingkungan Development) dan Linux Ubuntu Server 22.04 LTS (Lingkungan Server Production). |
| | **Framework Web (Laravel 12.x)** | Framework PHP modern berbasis arsitektur MVC (*Model-View-Controller*) sebagai fondasi *business logic*, routing, validasi, dan autentikasi multi-role. |
| | **Bahasa Pemrograman (PHP 8.3+)** | Bahasa pemrograman *server-side* utama yang menjalankan logika aplikasi dan pemrosesan data presensi. |
| | **Local Server Environment (XAMPP / Apache)** | Paket server web lokal Apache dan MySQL untuk tahap *development* dan *local testing*. |
| | **Database Management System (MySQL / MariaDB)** | Sistem manajemen basis data relasional untuk menyimpan tabel pengguna, siswa, guru, kelas, mapel, absensi, dan pelanggaran. |
| | **Database GUI Tool (phpMyAdmin / DBeaver)** | Antarmuka grafis untuk pemantauan struktur tabel, import data awal, dan optimasi query indeks basis data. |
| | **Frontend Styling & UI (Bootstrap 5.3 & Icons)** | Framework CSS responsif, Bootstrap Icons 1.11, dan font Google (*Plus Jakarta Sans*) untuk antarmuka pengguna yang bersih dan berstandar tinggi. |
| | **Asset Bundler & JS Tooling (Vite 7 & Node.js)** | Mengelola dependensi frontend dan melakukan kompilasi otomatis aset CSS/JavaScript secara instan. |
| | **Dependency Manager (Composer & NPM)** | Composer untuk pustaka dependensi PHP/Laravel, dan NPM untuk pustaka modul JavaScript. |
| | **Source Code Editor (Visual Studio Code)** | Editor teks utama yang dilengkapi ekstensi *PHP Intelephense*, *Laravel Artisan*, dan *Tailwind/Bootstrap IntelliSense*. |
| | **Web Browser Modern (Chrome / Edge / Firefox)** | Peramban web untuk pratinjau antarmuka, *DevTools inspect element*, dan simulasi tampilan mobile/desktop. |
| | **Version Control System (Git & GitHub)** | Pelacak riwayat revisi kode, pencabangan (*branching*), kolaborasi pengembang, serta *cloud repository backup*. |
| | **Automated Testing Suite (PHPUnit 11)** | Pengujian otomatis (*Unit & Feature Test*) untuk memastikan validitas alur multi-role dan integritas data presensi. |
| **Bahan (*Data & Aset Digital*)** | **Data Master Siswa** | Dokumen data profil seluruh siswa aktif (NISN, Nama Lengkap, Jenis Kelamin, ID Kelas/Rombel). |
| | **Data Master Tenaga Pendidik (Guru)** | Dokumen data profil guru pengajar (NIP, Nama Lengkap, Kontak, Mata Pelajaran yang diampu). |
| | **Data Kurikulum Mata Pelajaran** | Daftar kode mata pelajaran, nama mapel, dan jenjang tingkatan kelas di SMKN 1 Kota Bekasi. |
| | **Data Jam & Jadwal Pelajaran** | Alokasi pembagian jam pelajaran ke-1 sampai ke-10 serta matriks jadwal mengajar harian. |
| | **Aset Logo & Identitas Sekolah** | File grafis Logo SMKN 1 Kota Bekasi format PNG resolusi tinggi transparan (rasio 1:1) dan favicon aplikasi. |
| | **Regulasi & Matriks Pelanggaran Kedisiplinan** | Daftar kategori tata tertib siswa, bobot skor/poin pelanggaran, dan klasifikasi tindakan pembinaan dari tim BK. |
| **Perangkat Pikir (*Brainware*)** | **Fullstack Web Developer** | Tenaga ahli yang merancang struktur basis data, menulis kode backend/frontend, menghubungkan integrasi antar peran, dan memastikan sistem bebas dari celah keamanan maupun *bug*. |
| | **System Administrator / IT Support Sekolah** | Bertanggung jawab terhadap konfigurasi domain `.sch.id`, instalasi SSL certificate, pemeliharaan server VPS, dan otomasi jadwal *cloud backup*. |
| | **Guru Mata Pelajaran (*End-User*)** | Pengguna yang melakukan presensi berkala di setiap jam pelajaran berlangsung, memantau kehadiran kelas, dan melihat riwayat absensi mapel. |
| | **Guru Piket (*End-User*)** | Petugas yang mencatat keterlambatan siswa di gerbang pagi hari, memantau rekapan kehadiran seluruh rombel, dan menangani izin keluar-masuk sekolah. |
| | **Guru Bimbingan Konseling / BK (*End-User*)** | Pengguna yang mengidentifikasi siswa dengan riwayat alpa/bolos tinggi, mencatat rekam jejak pelanggaran kedisiplinan, serta mengelola poin pembinaan. |
| | **Sekretaris Kelas (*End-User*)** | Siswa perwakilan kelas yang membantu guru mencatat draf awal kehadiran rekan sekelasnya pada jam pertama. |
| | **Siswa (*End-User*)** | Pengguna mandiri yang mengakses portal pribadi untuk melihat persentase kehadiran, riwayat ketidakhadiran per mapel, serta catatan kedisiplinan pribadi. |

---

### B. Hubungan Keterkaitan 4 Elemen Implementasi (Sinergi Sistem)

```
┌────────────────────────────────────────────────────────────────────────┐
│                        BRAINWARE (PENGGUNA SISTEM)                     │
│  Developer  •  Admin IT  •  Guru Mapel  •  Piket  •  BK  •  Sekretaris │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ Mengoperasikan
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                       PERANGKAT LUNAK (SOFTWARE)                       │
│     Laravel 12  •  PHP 8.3  •  MySQL  •  Bootstrap 5.3  •  Vite 7      │
└───────────────────┬────────────────────────────────┬───────────────────┘
                    │ Memproses                      │ Berjalan di atas
                    ▼                                ▼
┌───────────────────────────────────────┐  ┌─────────────────────────────┐
│          BAHAN (DATA & ASET)          │  │  PERANGKAT KERAS (HARDWARE) │
│ • Data Siswa & Guru                   │  │ • Server Cloud VPS 4GB      │
│ • Jadwal & Jam Pelajaran              │  │ • Laptop Developer / PC     │
│ • Aturan Poin Pelanggaran             │  │ • Smartphone Klien          │
│ • Logo & Identitas SMKN 1 Kota Bekasi │  │ • Jaringan Internet Wi-Fi   │
└───────────────────────────────────────┘  └─────────────────────────────┘
```

---

### C. Ringkasan Evaluasi Kesiapan Sistem

1. **Efisiensi Infrastruktur:** Sistem web-based tidak membebani kapasitas memori ponsel siswa maupun guru karena dapat diakses secara instan melalui peramban web modern (*Google Chrome, Safari, Edge*).
2. **Kesiapan Data (*Bahan*):** Struktur data telah dinormalisasi ke dalam relasi database MySQL yang solid (`siswa`, `guru`, `kelas`, `mapel`, `absensis`, `pelanggarans`).
3. **Pemisahan Peran (*Brainware*):** Setiap pengguna hanya memiliki akses sesuai dengan batas wewenangnya melalui *Role-Based Access Control* (RBAC), sehingga integritas data presensi dan kerahasiaan catatan kedisiplinan siswa tetap terjaga secara aman.
