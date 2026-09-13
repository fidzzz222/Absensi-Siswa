@extends('layouts.app')

@section('title', 'Dashboard Guru Mapel')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Banner -->
    <div class="card-custom p-4 mb-4 bg-primary text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-2">Panel Guru Pengajar</span>
                <h2 class="fw-bold mb-1 text-white">Selamat Datang, {{ auth()->user()->name }}</h2>
                <p class="mb-3 text-white" style="opacity: 0.9;">Kelola absensi kelas mata pelajaran dan pantau kehadiran siswa SMKN 1 Kota Bekasi secara real-time.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('guru.absen.form') }}" class="btn btn-light fw-semibold text-primary px-3 py-2 rounded-3">
                        <i class="bi bi-pencil-square me-1"></i> Mulai Input Absensi
                    </a>
                    <a href="{{ route('dashboard.absen') }}" class="btn btn-outline-light fw-semibold px-3 py-2 rounded-3">
                        <i class="bi bi-table me-1"></i> Rekap Semua Absensi
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-person-workspace text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
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
                <small class="text-dark text-opacity-75">Siswa Berizin</small>
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

    <!-- Quick Info & Recent Attendance -->
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-custom p-4 h-100">
                <h5 class="fw-bold mb-3 d-flex align-items-center text-dark">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i> Ringkasan Sistem
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="text-muted"><i class="bi bi-mortarboard me-2"></i>Total Kelas</span>
                        <span class="fw-bold text-dark">{{ $totalKelas }} Kelas</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="text-muted"><i class="bi bi-book me-2"></i>Mata Pelajaran</span>
                        <span class="fw-bold text-dark">{{ $totalMapel }} Mapel</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="text-muted"><i class="bi bi-people me-2"></i>Total Seluruh Siswa</span>
                        <span class="fw-bold text-dark">{{ $totalSiswa }} Siswa</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="text-muted"><i class="bi bi-calendar3 me-2"></i>Tanggal Hari Ini</span>
                        <span class="badge bg-secondary-subtle text-secondary">{{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}</span>
                    </li>
                </ul>

                <div class="mt-4 p-3 bg-light rounded-3">
                    <div class="fw-semibold small text-primary mb-1">Panduan Singkat Absensi:</div>
                    <small class="text-muted d-block">
                        1. Klik menu <strong>Input Absensi</strong><br>
                        2. Pilih Guru, Mapel, Kelas, dan Jam ke<br>
                        3. Klik <strong>Tampilkan Siswa</strong> & isi status kehadiran<br>
                        4. Klik <strong>Simpan Absensi</strong>
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-primary me-2"></i> Riwayat Absensi Terbaru
                    </h5>
                    <a href="{{ route('dashboard.absen') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($riwayatTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Jam Ke</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatTerbaru as $absen)
                            <tr>
                                <td><small class="text-muted">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</small></td>
                                <td>
                                    <div class="fw-semibold">{{ $absen->siswa->nama ?? '-' }}</div>
                                    <small class="text-muted">{{ $absen->siswa->nisn ?? '' }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $absen->kelas->nama_kelas ?? '-' }}</span></td>
                                <td><small>{{ $absen->mapel->nama_mapel ?? '-' }}</small></td>
                                <td><span class="badge bg-secondary">Jam {{ $absen->jam_ke }}</span></td>
                                <td>
                                    @if($absen->status === 'Masuk')
                                        <span class="badge badge-masuk">Masuk</span>
                                    @elseif($absen->status === 'Izin')
                                        <span class="badge badge-izin">Izin</span>
                                    @elseif($absen->status === 'Sakit')
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
                    <p class="mb-0">Belum ada data absensi yang dicatat.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
