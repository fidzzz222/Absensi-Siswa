# RENCANA ANGGARAN BIAYA (RAB) & PENENTUAN HARGA JUAL
## PENGEMBANGAN SISTEM INFORMASI PRESENSI & KEDISIPLINAN SISWA (SI-HADIR)
### SMK NEGERI 1 KOTA BEKASI
**Durasi Kontrak / Lisensi:** 1 Tahun (12 Bulan)  
**Teknologi:** Laravel 12, PHP 8.3, MySQL, Bootstrap 5, Multi-Role Access Control  

---

### A. Justifikasi Kebutuhan Teknis Sistem

Aplikasi **SiHadir** dirancang untuk menangani beban operasional sekolah dengan 5 hak akses pengguna (*Guru Mapel, Siswa, Sekretaris Kelas, Guru BK, dan Guru Piket*). Estimasi transaksi harian:
* Jumlah Siswa: ~1.200 – 1.800 Siswa (36+ Rombel)
* Transaksi Presensi Harian: Presensi per jam pelajaran (8–10 jam per hari x 36 rombel)
* Kebutuhan Server: Server Cloud VPS RAM 4GB dibutuhkan untuk mencegah *bottleneck* atau *down* (Error 504) saat seluruh guru dan sekretaris menginput data secara serentak pada pagi hari.
* Cadangan Cloud (Backup): Menjamin data riwayat kehadiran dan catatan kedisiplinan siswa tersimpan aman dan terenkripsi di luar server utama.

---

### B. Rincian Rencana Anggaran Biaya (RAB)

#### 1. Biaya Tenaga (SDM)
| No | Tenaga Ahli / Posisi | Deskripsi Tugas | Estimasi Biaya |
| :-: | :--- | :--- | :-: |
| 1 | **Web Developer (Fullstack Engineer)** | Perancangan arsitektur database, implementasi logika multi-role 5 level, integrasi alur presensi guru-piket-sekretaris, pembuatan portal siswa, dashboard BK, dan unit/feature testing. | Rp 5.000.000 |
| **Total** | | | **Rp 5.000.000** |

---

#### 2. Biaya Infrastruktur (Tahunan)
| No | Komponen Infrastruktur | Spesifikasi & Rincian Durasi | Estimasi Biaya |
| :-: | :--- | :--- | :-: |
| 1 | **Sewa Cloud VPS Server** | KVM VPS RAM 4GB, 2 Core vCPU, 50GB NVMe SSD, Bandwidth Unlimited *(Rp 245.000/bulan x 12 bulan)* | Rp 2.940.000 |
| 2 | **Registrasi Domain `.sch.id`** | Domain resmi sekolah dari PANDI / Registrar resmi *(Masa aktif 1 tahun)* | Rp 50.000 |
| 3 | **Cloud Storage Backup Cadangan** | Penyimpanan arsip database & log harian otomatis terenkripsi kapasitas 500GB *(Rp 160.000/bulan x 12 bulan)* | Rp 1.920.000 |
| **Total** | | | **Rp 4.910.000** |

---

#### 3. Biaya Operasional & Implementasi
| No | Pos Operasional | Deskripsi Kebutuhan | Estimasi Biaya |
| :-: | :--- | :--- | :-: |
| 1 | **Listrik & Internet** | Alokasi utilitas selama tahapan development, deployment, dan pengujian sistem | Rp 400.000 |
| 2 | **Konsumsi & Rapat Koordinasi** | UAT (*User Acceptance Testing*) & koordinasi lapangan bersama tim kesiswaan / kurikulum | Rp 300.000 |
| 3 | **Sosialisasi & Dokumentasi (Modul SOP)** | Penyusunan Buku Panduan Pengguna (User Manual digital & cetak) untuk Guru, BK, Piket, dan Sekretaris | Rp 300.000 |
| **Total** | | | **Rp 1.000.000** |

---

#### 4. Biaya Lainnya (Cadangan)
| No | Komponen Lainnya | Deskripsi Kebutuhan | Estimasi Biaya |
| :-: | :--- | :--- | :-: |
| 1 | **Dana Tak Terduga (*Contingency Fund*)** | Alokasi darurat untuk fluktuasi kurs, penyesuaian dependensi sistem, atau perpanjangan lisensi darurat | Rp 500.000 |
| **Total** | | | **Rp 500.000** |

---

### C. Rekapitulasi & Penentuan Harga Jual

#### 1. Rincian Total Biaya (Modal Keseluruhan)
* Biaya Tenaga (SDM) = **Rp 5.000.000**
* Biaya Infrastruktur (1 Tahun) = **Rp 4.910.000**
* Biaya Operasional = **Rp 1.000.000**
* Biaya Lainnya (Dana Tak Terduga) = **Rp 500.000**

$$\text{Total Biaya (Modal)} = \text{Rp } 5.000.000 + 4.910.000 + 1.000.000 + 500.000 = \mathbf{\text{Rp } 11.410.000}$$

#### 2. Margin Keuntungan (15%)
$$\text{Margin Keuntungan (15\%)} = \text{Total Biaya} \times 15\%$$
$$\text{Keuntungan} = \text{Rp } 11.410.000 \times 15\% = \mathbf{\text{Rp } 1.711.500}$$

#### 3. Perhitungan Harga Penawaran / Harga Jual
$$\text{Harga Penawaran} = \text{Total Biaya} + \text{Keuntungan}$$
$$\text{Harga Penawaran} = \text{Rp } 11.410.000 + \text{Rp } 1.711.500 = \mathbf{\text{Rp } 13.121.500}$$

#### 4. Pembulatan Harga Jual
Dibulatkan secara komersial menjadi:
$$\mathbf{\text{Rp } 13.120.000} \quad \text{atau} \quad \mathbf{\text{Rp } 13.150.000}$$

---

### D. Hasil Akhir untuk Lembar Laporan / Pengajuan

| Komponen | Nilai (Rupiah) | Keterangan |
| :--- | :---: | :--- |
| **Modal / Total Biaya Riil** | **Rp 11.410.000** | Total kebutuhan pengembangan & operasional 1 tahun |
| **Keuntungan (Margin 15%)** | **Rp 1.711.500** | Laba bersih pengembang sistem |
| **Harga Penawaran / Harga Jual** | **Rp 13.120.000** | Nilai kontrak paket lengkap tahun pertama |

*(Terbilang: **Tiga Belas Juta Seratus Dua Puluh Ribu Rupiah** untuk durasi 1 tahun operasional)*

---

### E. Biaya Operasional Tahun Berikutnya (Perpanjangan / Recurring)
Jika sekolah melanjutkan kerja sama di tahun kedua dan seterusnya, sekolah **tidak perlu membayar lagi biaya pengembangan aplikasi (SDM)**, melainkan hanya biaya pemeliharaan dan server tahunan:

| No | Komponen Tahunan | Estimasi Biaya / Tahun |
| :-: | :--- | :-: |
| 1 | Perpanjangan Sewa VPS RAM 4GB | Rp 2.940.000 |
| 2 | Perpanjangan Domain `.sch.id` | Rp 50.000 |
| 3 | Perpanjangan Cloud Backup 500GB | Rp 1.920.000 |
| 4 | Biaya Maintenance & Dukungan Teknis (*Bugfix & Update Ringan*) | Rp 1.500.000 |
| **Total Biaya Perpanjangan (Tahun ke-2 dst)** | | **Rp 6.410.000 / tahun** |
