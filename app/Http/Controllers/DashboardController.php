<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Pelanggaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Guru Mapel
     */
    public function guru()
    {
        $user = Auth::user();
        $guru = Guru::where('nama', 'like', '%' . $user->name . '%')->first() ?? Guru::first();

        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();
        $totalSiswa = Siswa::count();

        $today = Carbon::today()->toDateString();

        $absensiHariIni = Absensi::where('tanggal', $today)
            ->when($guru, fn($q) => $q->where('guru_id', $guru->id))
            ->get();

        $stats = [
            'masuk' => $absensiHariIni->where('status', 'Masuk')->count(),
            'izin' => $absensiHariIni->where('status', 'Izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'Sakit')->count(),
            'alfa' => $absensiHariIni->where('status', 'Alfa')->count(),
        ];

        // Riwayat sesi absensi terakhir yang diinput guru
        $riwayatTerbaru = Absensi::with(['kelas', 'mapel', 'siswa'])
            ->when($guru, fn($q) => $q->where('guru_id', $guru->id))
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_ke', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.guru', compact(
            'guru', 'totalKelas', 'totalMapel', 'totalSiswa', 'stats', 'riwayatTerbaru', 'today'
        ));
    }

    /**
     * Dashboard Siswa
     */
    public function siswa()
    {
        $user = Auth::user();
        $siswa = Siswa::with('kelas')
            ->where('nama', 'like', '%' . $user->name . '%')
            ->first() ?? Siswa::with('kelas')->first();

        $absensiQuery = Absensi::where('siswa_id', $siswa?->id);

        $totalMasuk = (clone $absensiQuery)->where('status', 'Masuk')->count();
        $totalIzin = (clone $absensiQuery)->where('status', 'Izin')->count();
        $totalSakit = (clone $absensiQuery)->where('status', 'Sakit')->count();
        $totalAlfa = (clone $absensiQuery)->where('status', 'Alfa')->count();
        $totalPertemuan = $totalMasuk + $totalIzin + $totalSakit + $totalAlfa;

        $persenKehadiran = $totalPertemuan > 0
            ? round(($totalMasuk / $totalPertemuan) * 100, 1)
            : 100;

        $riwayatAbsensi = Absensi::with(['mapel', 'guru'])
            ->where('siswa_id', $siswa?->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_ke', 'desc')
            ->take(15)
            ->get();

        $pelanggaran = Pelanggaran::with('penangan')
            ->where('siswa_id', $siswa?->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('dashboard.siswa', compact(
            'siswa', 'totalMasuk', 'totalIzin', 'totalSakit', 'totalAlfa',
            'totalPertemuan', 'persenKehadiran', 'riwayatAbsensi', 'pelanggaran'
        ));
    }

    /**
     * Dashboard Sekretaris Kelas
     */
    public function sekretaris()
    {
        // Default kelas 1 (XI RPL A)
        $kelas = Kelas::first();
        $today = Carbon::today()->toDateString();

        $siswaKelas = Siswa::where('kelas_id', $kelas?->id)->get();
        $totalSiswa = $siswaKelas->count();

        $absensiHariIni = Absensi::where('kelas_id', $kelas?->id)
            ->where('tanggal', $today)
            ->get();

        $stats = [
            'masuk' => $absensiHariIni->where('status', 'Masuk')->count(),
            'izin' => $absensiHariIni->where('status', 'Izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'Sakit')->count(),
            'alfa' => $absensiHariIni->where('status', 'Alfa')->count(),
        ];

        $riwayatAbsensi = Absensi::with(['siswa', 'mapel', 'guru'])
            ->where('kelas_id', $kelas?->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_ke', 'desc')
            ->take(15)
            ->get();

        return view('dashboard.sekretaris', compact(
            'kelas', 'totalSiswa', 'stats', 'today', 'riwayatAbsensi'
        ));
    }

    /**
     * Dashboard Guru BK (Bimbingan Konseling)
     */
    public function guruBk()
    {
        // Siswa dengan rekap absensi terbanyak (alfa, sakit, izin)
        $siswaBermasalah = Siswa::with('kelas')
            ->withCount([
                'absensi as total_alfa' => fn($q) => $q->where('status', 'Alfa'),
                'absensi as total_izin' => fn($q) => $q->where('status', 'Izin'),
                'absensi as total_sakit' => fn($q) => $q->where('status', 'Sakit'),
                'pelanggaran as total_pelanggaran',
            ])
            ->having('total_alfa', '>', 0)
            ->orHaving('total_pelanggaran', '>', 0)
            ->orderByDesc('total_alfa')
            ->orderByDesc('total_pelanggaran')
            ->take(10)
            ->get();

        $totalPelanggaran = Pelanggaran::count();
        $totalAlfaSemua = Absensi::where('status', 'Alfa')->count();
        $totalSiswa = Siswa::count();

        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'pencatat', 'penangan'])
            ->orderBy('tanggal', 'desc')
            ->take(8)
            ->get();

        return view('dashboard.guru_bk', compact(
            'siswaBermasalah', 'totalPelanggaran', 'totalAlfaSemua', 'totalSiswa', 'pelanggaranTerbaru'
        ));
    }

    /**
     * Dashboard Guru Piket
     */
    public function guruPiket()
    {
        $today = Carbon::today()->toDateString();

        $kelas = Kelas::all();
        $totalSiswa = Siswa::count();

        // Absensi hari ini di seluruh sekolah
        $absensiHariIni = Absensi::with(['siswa.kelas', 'mapel'])
            ->where('tanggal', $today)
            ->get();

        $stats = [
            'masuk' => $absensiHariIni->where('status', 'Masuk')->count(),
            'izin' => $absensiHariIni->where('status', 'Izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'Sakit')->count(),
            'alfa' => $absensiHariIni->where('status', 'Alfa')->count(),
        ];

        // Siswa yang tidak hadir hari ini (Izin / Sakit / Alfa)
        $siswaTidakHadirHariIni = $absensiHariIni->whereIn('status', ['Izin', 'Sakit', 'Alfa']);

        $pelanggaranHariIni = Pelanggaran::with(['siswa.kelas', 'pencatat'])
            ->where('tanggal', $today)
            ->get();

        return view('dashboard.guru_piket', compact(
            'today', 'kelas', 'totalSiswa', 'stats', 'siswaTidakHadirHariIni', 'pelanggaranHariIni'
        ));
    }
}
