@extends('layouts.app')

@section('title', 'Dashboard Bimbingan Konseling (BK)')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Banner BK -->
    <div class="card-custom p-4 mb-4 text-white" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-dark fw-bold px-3 py-1 mb-2">Layanan Bimbingan Konseling</span>
                <h2 class="fw-bold mb-1 text-white">Dashboard Guru BK - {{ auth()->user()->name }}</h2>
                <p class="mb-3 text-white" style="opacity: 0.9;">
                    Pantau tingkat ketidakhadiran (Alfa/Bolos), rekap pelanggaran disiplin siswa, dan catat pembinaan secara terpadu.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-light fw-semibold text-primary px-3 py-2 rounded-3">
                        <i class="bi bi-plus-circle me-1"></i> Catat Kasus / Pelanggaran Baru
                    </a>
                    <a href="{{ route('pelanggaran.index') }}" class="btn btn-outline-light fw-semibold px-3 py-2 rounded-3">
                        <i class="bi bi-shield-exclamation me-1"></i> Semua Catatan Pelanggaran
                    </a>
                    <a href="{{ route('dashboard.absen', ['status' => 'Alfa']) }}" class="btn btn-outline-light fw-semibold px-3 py-2 rounded-3">
                        <i class="bi bi-person-x me-1"></i> Pantau Rekap Alfa
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-heart-pulse text-white opacity-25" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    <!-- Stats Summary BK -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-card bg-danger text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Total Rekap Alfa</small>
                <h2 class="fw-bold my-1 text-white">{{ $totalAlfaSemua }}</h2>
                <small class="text-white text-opacity-75">Sesi Tanpa Keterangan</small>
                <i class="bi bi-exclamation-triangle stat-icon text-white"></i>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="stat-card bg-warning text-dark">
                <small class="text-dark text-opacity-75 text-uppercase fw-bold">Total Pelanggaran</small>
                <h2 class="fw-bold my-1 text-dark">{{ $totalPelanggaran }}</h2>
                <small class="text-dark text-opacity-75">Kasus Siswa Dicatat</small>
                <i class="bi bi-clipboard2-x stat-icon text-dark"></i>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card bg-primary text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Total Siswa Terdaftar</small>
                <h2 class="fw-bold my-1 text-white">{{ $totalSiswa }}</h2>
                <small class="text-white text-opacity-75">Siswa Dalam Pemantauan</small>
                <i class="bi bi-people stat-icon text-white"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Siswa Butuh Perhatian Khusus (Alfa / Pelanggaran Terbanyak) -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-exclamation text-danger me-2"></i> Siswa Prioritas Bimbingan
                    </h5>
                    <span class="badge bg-danger-subtle text-danger">Alfa & Pelanggaran</span>
                </div>

                @if($siswaBermasalah->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Total Alfa</th>
                                <th class="text-center">Pelanggaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaBermasalah as $s)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $s->nama }}</div>
                                    <small class="text-muted">NISN: {{ $s->nisn }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $s->kelas->nama_kelas ?? '-' }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $s->total_alfa > 0 ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ $s->total_alfa }} kali
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $s->total_pelanggaran > 0 ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                        {{ $s->total_pelanggaran }} kasus
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pelanggaran.create', ['siswa_id' => $s->id]) }}" class="btn btn-sm btn-outline-danger" title="Beri Catatan / Pembinaan">
                                        <i class="bi bi-plus-circle"></i> Bimbing
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-emoji-smile fs-1 text-success d-block mb-2"></i>
                    <p class="mb-0">Semua siswa tertib dan tidak ada rekap alfa/pelanggaran yang menonjol.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Pelanggaran Terakhir Dicatat -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-primary me-2"></i> Kasus Terbaru
                    </h5>
                    <a href="{{ route('pelanggaran.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Lihat Semua
                    </a>
                </div>

                @if($pelanggaranTerbaru->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($pelanggaranTerbaru as $p)
                    <li class="list-group-item px-0 py-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <span class="fw-semibold text-dark">{{ $p->siswa->nama ?? '-' }}</span>
                                <small class="text-muted d-block">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</small>
                            </div>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $p->jenis }}</span>
                        </div>
                        <p class="mb-1 small text-secondary">{{ $p->keterangan ?? 'Tidak ada keterangan rinci' }}</p>
                        <div class="d-flex justify-content-between align-items-center small text-muted">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</span>
                            @if($p->tindakan)
                                <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $p->tindakan }}</span>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-check2-circle fs-1 text-success d-block mb-2"></i>
                    Belum ada pelanggaran yang tercatat baru-baru ini.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
