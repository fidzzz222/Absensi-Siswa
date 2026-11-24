# ANALISIS IMPLEMENTASI KEBUTUHAN SISTEM (ALAT, BAHAN, & BRAINWARE)
## SISTEM INFORMASI PRESENSI & KEDISIPLINAN SISWA (SI-HADIR)
### SMK NEGERI 1 KOTA BEKASI

Dokumen ini memuat analisis spesifikasi kebutuhan implementasi proyek yang terdiri dari **Perangkat Keras (*Hardware*)**, **Perangkat Lunak (*Software*)**, **Bahan (*Data & Aset Digital*)**, serta **Perangkat Pikir (*Brainware*)** yang disesuaikan secara presisi dengan arsitektur teknis aplikasi Si-Hadir.

---

### A. Tabel Kebutuhan Alat, Bahan, dan Brainware (Versi Ringkas)

| Kategori | Alat / Bahan / SDM | Keterangan / Fungsi Inti |
| :--- | :--- | :--- |
| **Perangkat Keras (*Hardware*)** | **Laptop / PC** | Perangkat utama pengembangan aplikasi |
| | **Server Cloud VPS** | Hosting server produksi (RAM 4GB) |
| | **Perangkat Klien** | Akses web portal bagi pengguna (HP/Laptop) |
| | **Mouse & Keyboard** | Perangkat input navigasi dan pengetikan |
| | **Koneksi Internet** | Akses jaringan, sinkronisasi, dan deploy |
| **Perangkat Lunak (*Software*)** | **Sistem Operasi** | Windows (Development) & Linux (Server) |
| | **Laravel 12** | Framework backend utama (arsitektur MVC) |
| | **PHP 8.3** | Bahasa pemrograman server-side |
| | **XAMPP / Apache** | Web server lokal dan database testing |
| | **MySQL / phpMyAdmin** | Basis data relasional dan alat pengelola |
| | **Bootstrap 5.3 & Icons** | Styling antarmuka responsif dan ikon |
| | **Vite & Node.js** | Bundling aset CSS dan JavaScript |
| | **Composer & NPM** | Pengelola paket dependensi proyek |
| | **Visual Studio Code** | Code editor penulisan program |
| | **Web Browser** | Pengujian tampilan dan alur aplikasi |
| | **Git & GitHub** | Version control dan penyimpanan repositori |
| | **PHPUnit** | Pengujian otomatis (Feature & Unit Test) |
| **Bahan (*Data & Aset*)** | **Data Siswa & Guru** | Data master identitas pengguna presensi |
| | **Data Mapel & Jadwal** | Data master alokasi jam mengajar |
| | **Logo SMKN 1 Kota Bekasi** | Aset visual dan identitas antarmuka |
| | **Aturan Tata Tertib** | Acuan kategori dan poin pelanggaran BK |
| **Perangkat Pikir (*Brainware*)** | **Fullstack Developer** | Perancang dan pembuat sistem aplikasi |
| | **Administrator IT** | Pengelola server, domain, dan backup data |
| | **Guru Mapel** | Penginput presensi per jam pelajaran |
| | **Guru Piket** | Pencatat keterlambatan gerbang sekolah |
| | **Guru BK** | Pemantau absensi & pengelola poin pelanggaran |
| | **Sekretaris Kelas** | Pembantu pencatat draf presensi kelas |
| | **Siswa** | Pemantau rekap presensi dan poin pribadi |

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
