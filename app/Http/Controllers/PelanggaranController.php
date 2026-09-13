<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;

class PelanggaranController extends Controller
{
    /**
     * Tampilkan daftar catatan pelanggaran siswa
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $query = Pelanggaran::with(['siswa.kelas', 'pencatat', 'penangan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->whereHas('siswa', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%");
            })->orWhere('jenis', 'like', "%{$keyword}%");
        }

        $pelanggaran = $query->paginate(20)->withQueryString();

        return view('dashboard.pelanggaran', compact('pelanggaran', 'kelasList'));
    }

    /**
     * Form tambah catatan pelanggaran
     */
    public function create()
    {
        $siswaList = Siswa::with('kelas')->orderBy('nama')->get();
        $today = Carbon::today()->toDateString();

        return view('dashboard.pelanggaran_form', compact('siswaList', 'today'));
    }

    /**
     * Simpan catatan pelanggaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ], [
            'siswa_id.required' => 'Silakan pilih siswa.',
            'tanggal.required' => 'Tanggal pelanggaran wajib diisi.',
            'jenis.required' => 'Jenis pelanggaran wajib diisi.',
        ]);

        Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'pencatat_id' => Auth::id() ?? 1,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'ditangani_oleh' => Auth::id() ?? 1,
            'tindakan' => $request->tindakan,
        ]);

        return redirect()->route('pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil disimpan!');
    }

    /**
     * Hapus catatan pelanggaran
     */
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil dihapus!');
    }
}
