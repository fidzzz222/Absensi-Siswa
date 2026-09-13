<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Form Input Absensi Guru / Sekretaris
     */
    public function formGuru(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $jam = JamPelajaran::orderBy('jam_ke')->get();
        $guru = Guru::orderBy('nama')->get();

        $data_siswa = [];
        $existing_status = [];

        $tanggalDipilih = $request->input('tanggal', Carbon::today()->toDateString());

        if ($request->filled('kelas_id')) {
            $data_siswa = Siswa::where('kelas_id', $request->kelas_id)
                ->orderBy('nama', 'asc')
                ->get();

            // Cek apakah sudah pernah diabsen di jam & mapel & tanggal ini
            if ($request->filled('tanggal') && $request->filled('jam_ke') && $request->filled('mapel_id')) {
                $existing_status = Absensi::where('kelas_id', $request->kelas_id)
                    ->where('mapel_id', $request->mapel_id)
                    ->where('jam_ke', $request->jam_ke)
                    ->where('tanggal', $request->tanggal)
                    ->pluck('status', 'siswa_id')
                    ->toArray();
            }
        }

        return view('dashboardd.absen', compact(
            'kelas', 'mapel', 'guru', 'jam', 'data_siswa', 'existing_status', 'tanggalDipilih'
        ));
    }

    /**
     * Simpan / Perbarui Absensi
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'jam_ke' => 'required|integer',
            'status' => 'required|array',
        ], [
            'guru_id.required' => 'Silakan pilih guru pengajar.',
            'mapel_id.required' => 'Silakan pilih mata pelajaran.',
            'kelas_id.required' => 'Silakan pilih kelas.',
            'tanggal.required' => 'Tanggal absensi wajib diisi.',
            'jam_ke.required' => 'Silakan pilih jam pelajaran.',
            'status.required' => 'Daftar status absensi siswa tidak boleh kosong.',
        ]);

        $count = 0;
        foreach ($request->status as $siswa_id => $status) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal' => $request->tanggal,
                    'jam_ke' => $request->jam_ke,
                    'mapel_id' => $request->mapel_id,
                ],
                [
                    'guru_id' => $request->guru_id,
                    'kelas_id' => $request->kelas_id,
                    'status' => $status,
                ]
            );
            $count++;
        }

        return redirect()
            ->route('guru.absen.form', [
                'kelas_id' => $request->kelas_id,
                'guru_id' => $request->guru_id,
                'mapel_id' => $request->mapel_id,
                'tanggal' => $request->tanggal,
                'jam_ke' => $request->jam_ke,
            ])
            ->with('success', "Data absensi untuk {$count} siswa berhasil disimpan!");
    }

    /**
     * Halaman Rekap / Pencarian Absensi (Umum / Siswa)
     */
    public function absenView(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = Mapel::orderBy('nama_mapel')->get();

        $query = Absensi::with(['siswa.kelas', 'mapel', 'guru'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_ke', 'asc');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('nama_kelas', 'like', "%{$request->kelas}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('jam_ke')) {
            $query->where('jam_ke', $request->jam_ke);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->whereHas('siswa', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%");
            });
        }

        $results = $query->paginate(25)->withQueryString();

        return view('dashboard.absen', compact('results', 'kelasList', 'mapelList'));
    }

    /**
     * Search handler (backward compatibility)
     */
    public function searchAbsen(Request $request)
    {
        return $this->absenView($request);
    }
}
