@extends('layouts.app')

@section('title', 'Dashboard Guru Piket')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Banner Piket -->
    <div class="card-custom p-4 mb-4 text-white" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-dark fw-bold px-3 py-1 mb-2">Piket Harian Sekolah</span>
                <h2 class="fw-bold mb-1 text-white">Piket Harian - {{ auth()->user()->name }}</h2>
                <p class="mb-3 text-white" style="opacity: 0.9;">
                    Pantau kehadiran seluruh rombel kelas hari ini ({{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}), dan catat siswa yang terlambat atau melanggar tata tertib.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-light fw-semibold text-dark px-3 py-2 rounded-3">
                        <i class="bi bi-clock-history me-1"></i> Catat Siswa Terlambat / Melanggar
                    </a>
                    <a href="{{ route('dashboard.absen', ['tanggal' => $today]) }}" class="btn btn-outline-light fw-semibold px-3 py-2 rounded-3">
                        <i class="bi bi-calendar-event me-1"></i> Rekap Semua Kelas Hari Ini
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-shield-check text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Statistik Absensi Seluruh Sekolah Hari Ini -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card bg-success text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Hadir Hari Ini</small>
                <h2 class="fw-bold my-1 text-white">{{ $stats['masuk'] }}</h2>
                <small class="text-white text-opacity-75">Total Jam Hadir</small>
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

    <div class="row g-4">
        <!-- Siswa Tidak Hadir Hari Ini -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-x text-danger me-2"></i> Siswa Tidak Masuk Hari Ini
                    </h5>
                    <span class="badge bg-danger-subtle text-danger">{{ $siswaTidakHadirHariIni->count() }} Record</span>
                </div>

                @if($siswaTidakHadirHariIni->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jam Ke</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaTidakHadirHariIni as $absen)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $absen->siswa->nama ?? '-' }}</div>
                                    <small class="text-muted">NISN: {{ $absen->siswa->nisn ?? '-' }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $absen->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                                <td>Jam {{ $absen->jam_ke }}</td>
                                <td>
                                    @if($absen->status === 'Izin')
                                        <span class="badge badge-izin">Izin</span>
                                    @elseif($absen->status === 'Sakit')
                                        <span class="badge badge-sakit">Sakit</span>
                                    @else
                                        <span class="badge badge-alfa">Alfa</span>
                                    @endif
                                </td>
                                <td>
                                    @if($absen->status === 'Alfa')
                                    <a href="{{ route('pelanggaran.create', ['siswa_id' => $absen->siswa_id]) }}" class="btn btn-sm btn-outline-danger" title="Catat sebagai pelanggaran bolos">
                                        <i class="bi bi-exclamation-octagon"></i> Catat
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-check-circle-fill fs-1 text-success d-block mb-2"></i>
                    <p class="mb-0">Tidak ada siswa yang berstatus Izin, Sakit, atau Alfa hari ini. Semua hadir sempurna!</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Pelanggaran / Keterlambatan Hari Ini -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-warning me-2"></i> Catatan Pelanggaran Hari Ini
                    </h5>
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-sm btn-primary rounded-pill">
                        <i class="bi bi-plus"></i> Tambah
                    </a>
                </div>

                @if($pelanggaranHariIni->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($pelanggaranHariIni as $p)
                    <li class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <span class="fw-semibold text-dark">{{ $p->siswa->nama ?? '-' }}</span>
                                <small class="text-muted d-block">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</small>
                            </div>
                            <span class="badge bg-warning text-dark">{{ $p->jenis }}</span>
                        </div>
                        <p class="mb-1 small text-secondary">{{ $p->keterangan ?? '-' }}</p>
                        @if($p->tindakan)
                        <small class="text-success"><i class="bi bi-check-lg me-1"></i>{{ $p->tindakan }}</small>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-emoji-smile fs-1 text-success d-block mb-2"></i>
                    <p class="mb-0">Belum ada catatan pelanggaran atau keterlambatan hari ini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
