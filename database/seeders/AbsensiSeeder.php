<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\JamPelajaran;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Pelanggaran;
use App\Models\User;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Guru Agus Haryanto ada
        Guru::firstOrCreate(
            ['nip' => '198205102008011005'],
            ['nama' => 'Agus Haryanto']
        );

        // 2. Tambah Mapel Umum jika belum ada
        $mapels = ['Pemrograman Dasar', 'Basis Data', 'PBO', 'PKK', 'Matematika Terapan', 'Bahasa Indonesia'];
        foreach ($mapels as $m) {
            Mapel::firstOrCreate(['nama_mapel' => $m]);
        }

        // 3. Pastikan Jam Pelajaran 1 s/d 8
        for ($i = 1; $i <= 8; $i++) {
            JamPelajaran::firstOrCreate(['jam_ke' => $i]);
        }

        // 4. Pastikan Kelas XI RPL A & B
        $kelasA = Kelas::firstOrCreate(['nama_kelas' => 'XI RPL A']);
        $kelasB = Kelas::firstOrCreate(['nama_kelas' => 'XI RPL B']);

        // 5. Pastikan Siswa Doni Saputra ada di XI RPL A
        $doni = Siswa::firstOrCreate(
            ['nisn' => '0093383099'],
            [
                'nama' => 'Doni Saputra',
                'jenis_kelamin' => 'L',
                'kelas_id' => $kelasA->id,
                'kontak' => '081234567890',
            ]
        );

        // Tambah beberapa siswa di XI RPL B jika kosong
        if (Siswa::where('kelas_id', $kelasB->id)->count() === 0) {
            $siswaB = [
                ['nisn' => '0093384001', 'nama' => 'Fajar Nugroho', 'jenis_kelamin' => 'L'],
                ['nisn' => '0093384002', 'nama' => 'Gita Permata', 'jenis_kelamin' => 'P'],
                ['nisn' => '0093384003', 'nama' => 'Hadi Wijaya', 'jenis_kelamin' => 'L'],
                ['nisn' => '0093384004', 'nama' => 'Indah Lestari', 'jenis_kelamin' => 'P'],
                ['nisn' => '0093384005', 'nama' => 'Joko Susilo', 'jenis_kelamin' => 'L'],
            ];
            foreach ($siswaB as $s) {
                Siswa::create([
                    'nisn' => $s['nisn'],
                    'nama' => $s['nama'],
                    'jenis_kelamin' => $s['jenis_kelamin'],
                    'kelas_id' => $kelasB->id,
                    'kontak' => '08' . rand(10000000, 99999999),
                ]);
            }
        }

        // 6. Buat contoh data absensi (hari ini & kemarin)
        $guru = Guru::first();
        $mapel = Mapel::first();
        $siswaList = Siswa::where('kelas_id', $kelasA->id)->get();

        $dates = [
            Carbon::yesterday()->toDateString(),
            Carbon::today()->toDateString(),
        ];

        foreach ($dates as $date) {
            foreach ($siswaList as $idx => $siswa) {
                // Doni selalu hadir contohnya
                if ($siswa->id === $doni->id) {
                    $status = 'Masuk';
                } else {
                    // Beberapa acak izin, sakit, alfa
                    if ($idx % 15 === 0) {
                        $status = 'Alfa';
                    } elseif ($idx % 11 === 0) {
                        $status = 'Sakit';
                    } elseif ($idx % 9 === 0) {
                        $status = 'Izin';
                    } else {
                        $status = 'Masuk';
                    }
                }

                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'tanggal' => $date,
                        'jam_ke' => 1,
                        'mapel_id' => $mapel->id,
                    ],
                    [
                        'guru_id' => $guru->id,
                        'kelas_id' => $kelasA->id,
                        'status' => $status,
                    ]
                );
            }
        }

        // 7. Buat contoh Pelanggaran
        $pencatat = User::where('role', 'guru_bk')->first() ?? User::first();
        $siswaMelanggar = Siswa::where('kelas_id', $kelasA->id)->skip(3)->first();

        if ($siswaMelanggar && Pelanggaran::count() === 0) {
            Pelanggaran::create([
                'siswa_id' => $siswaMelanggar->id,
                'pencatat_id' => $pencatat->id,
                'tanggal' => Carbon::today()->toDateString(),
                'jenis' => 'Terlambat Masuk',
                'keterangan' => 'Terlambat 20 menit saat jam pertama masuk',
                'ditangani_oleh' => $pencatat->id,
                'tindakan' => 'Diberikan teguran lisan dan pembinaan piket',
            ]);

            $siswaKedua = Siswa::where('kelas_id', $kelasA->id)->skip(5)->first();
            if ($siswaKedua) {
                Pelanggaran::create([
                    'siswa_id' => $siswaKedua->id,
                    'pencatat_id' => $pencatat->id,
                    'tanggal' => Carbon::yesterday()->toDateString(),
                    'jenis' => 'Seragam Tidak Lengkap',
                    'keterangan' => 'Tidak memakai dasi dan atribut logo sekolah',
                    'ditangani_oleh' => $pencatat->id,
                    'tindakan' => 'Peringatan pertama dan mencatat di buku tata tertib',
                ]);
            }
        }
    }
}
