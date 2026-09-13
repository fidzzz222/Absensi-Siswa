@extends('layouts.app')

@section('title', 'Dashboard Sekretaris Kelas')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Banner Sekretaris -->
    <div class="card-custom p-4 mb-4 text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-success fw-bold px-3 py-1 mb-2">Presensi Kelas</span>
                <h2 class="fw-bold mb-1 text-white">Halo, {{ auth()->user()->name }} (Sekretaris)</h2>
                <p class="mb-3 text-white" style="opacity: 0.9;">
                    Bantu guru mata pelajaran mencatat kehadiran rekan sekelas di <strong>{{ $kelas->nama_kelas ?? 'XI RPL A' }}</strong>.
                    Total siswa di kelas ini: <strong>{{ $totalSiswa }} Siswa</strong>.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('guru.absen.form', ['kelas_id' => $kelas->id ?? 1]) }}" class="btn btn-light fw-semibold text-success px-3 py-2 rounded-3">
                        <i class="bi bi-pencil-square me-1"></i> Catat Absensi Kelas Ini
                    </a>
                    <a href="{{ route('dashboard.absen', ['kelas_id' => $kelas->id ?? 1]) }}" class="btn btn-outline-light fw-semibold px-3 py-2 rounded-3">
                        <i class="bi bi-table me-1"></i> Rekap Absensi Kelas
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-journal-check text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Stats Kehadiran Kelas Hari Ini -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card bg-success text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Hadir Hari Ini</small>
                <h2 class="fw-bold my-1 text-white">{{ $stats['masuk'] }}</h2>
                <small class="text-white text-opacity-75">Siswa Masuk</small>
                <i class="bi bi-check-circle stat-icon text-white"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-warning text-dark">
                <small class="text-dark text-opacity-75 text-uppercase fw-bold">Izin Hari Ini</small>
                <h2 class="fw-bold my-1 text-dark">{{ $stats['izin'] }}</h2>
                <small class="text-dark text-opacity-75">Siswa Izin</small>
                <i class="bi bi-info-circle stat-icon text-dark"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-info text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Sakit Hari Ini</small>
                <h2 class="fw-bold my-1 text-white">{{ $stats['sakit'] }}</h2>
                <small class="text-white text-opacity-75">Siswa Sakit</small>
                <i class="bi bi-hospital stat-icon text-white"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-danger text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Alfa Hari Ini</small>
                <h2 class="fw-bold my-1 text-white">{{ $stats['alfa'] }}</h2>
                <small class="text-white text-opacity-75">Tanpa Keterangan</small>
                <i class="bi bi-x-circle stat-icon text-white"></i>
            </div>
        </div>
    </div>

    <!-- Riwayat Absensi Kelas -->
    <div class="card-custom p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-list-check text-success me-2"></i> Log Absensi Kelas {{ $kelas->nama_kelas ?? 'XI RPL A' }}
                </h5>
                <small class="text-muted">Menampilkan catatan absensi terbaru pada kelas Anda</small>
            </div>
            <a href="{{ route('dashboard.absen', ['kelas_id' => $kelas->id ?? 1]) }}" class="btn btn-sm btn-outline-success rounded-pill">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($riwayatAbsensi->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam Ke</th>
                        <th>Guru Pengajar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatAbsensi as $row)
                    <tr>
                        <td><small class="text-muted">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</small></td>
                        <td class="fw-semibold">{{ $row->siswa->nama ?? '-' }}</td>
                        <td><small class="text-muted">{{ $row->siswa->nisn ?? '-' }}</small></td>
                        <td>{{ $row->mapel->nama_mapel ?? '-' }}</td>
                        <td><span class="badge bg-secondary">Jam {{ $row->jam_ke }}</span></td>
                        <td><small class="text-muted">{{ $row->guru->nama ?? '-' }}</small></td>
                        <td>
                            @if($row->status === 'Masuk')
                                <span class="badge badge-masuk">Masuk</span>
                            @elseif($row->status === 'Izin')
                                <span class="badge badge-izin">Izin</span>
                            @elseif($row->status === 'Sakit')
                                <span class="badge badge-sakit">Sakit</span>
                            @else
                                <span class="badge badge-alfa">Alfa</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
            <p class="mb-0">Belum ada absensi tercatat di kelas ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
