@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Banner Siswa -->
    <div class="card-custom p-4 mb-4 text-white" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-info fw-bold px-3 py-1 mb-2">Portal Siswa</span>
                <h2 class="fw-bold mb-1 text-white">Hai, {{ $siswa->nama ?? auth()->user()->name }}!</h2>
                <p class="mb-2 text-white" style="opacity: 0.9;">
                    Kelas: <strong>{{ $siswa->kelas->nama_kelas ?? 'XI RPL A' }}</strong> |
                    NISN: <strong>{{ $siswa->nisn ?? '-' }}</strong> |
                    Jenis Kelamin: <strong>{{ ($siswa->jenis_kelamin ?? 'L') == 'L' ? 'Laki-laki' : 'Perempuan' }}</strong>
                </p>
                <div class="d-flex align-items-center flex-wrap gap-3 mt-3">
                    <div class="bg-white px-3 py-2 rounded-3 shadow-sm text-dark d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-pie-chart-fill fs-5"></i>
                        </div>
                        <div>
                            <small class="d-block text-secondary fw-semibold" style="font-size: 0.8rem;">Persentase Kehadiran</small>
                            <span class="fs-4 fw-bold text-primary">{{ $persenKehadiran }}%</span>
                        </div>
                    </div>
                    <div class="bg-white px-3 py-2 rounded-3 shadow-sm text-dark d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        <div>
                            <small class="d-block text-secondary fw-semibold" style="font-size: 0.8rem;">Total Jam Terdata</small>
                            <span class="fs-4 fw-bold text-dark">{{ $totalPertemuan }} Jam</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-mortarboard text-white opacity-25" style="font-size: 7rem;"></i>
            </div>
        </div>
    </div>

    <!-- Stat Cards Kehadiran Pribadi -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card bg-success text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Total Masuk</small>
                <h2 class="fw-bold my-1 text-white">{{ $totalMasuk }}</h2>
                <small class="text-white text-opacity-75">Jam Pelajaran</small>
                <i class="bi bi-check-circle stat-icon text-white"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-warning text-dark">
                <small class="text-dark text-opacity-75 text-uppercase fw-bold">Total Izin</small>
                <h2 class="fw-bold my-1 text-dark">{{ $totalIzin }}</h2>
                <small class="text-dark text-opacity-75">Jam Pelajaran</small>
                <i class="bi bi-info-circle stat-icon text-dark"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-info text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Total Sakit</small>
                <h2 class="fw-bold my-1 text-white">{{ $totalSakit }}</h2>
                <small class="text-white text-opacity-75">Jam Pelajaran</small>
                <i class="bi bi-hospital stat-icon text-white"></i>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card bg-danger text-white">
                <small class="text-white text-opacity-75 text-uppercase fw-bold">Total Alfa</small>
                <h2 class="fw-bold my-1 text-white">{{ $totalAlfa }}</h2>
                <small class="text-white text-opacity-75">Jam Pelajaran</small>
                <i class="bi bi-x-circle stat-icon text-white"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Riwayat Kehadiran Siswa -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-journal-text text-primary me-2"></i> Riwayat Kehadiran Saya
                    </h5>
                    <a href="{{ route('dashboard.absen', ['q' => $siswa->nama ?? '']) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Cari Lengkap
                    </a>
                </div>

                @if($riwayatAbsensi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Jam Ke</th>
                                <th>Guru</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatAbsensi as $item)
                            <tr>
                                <td><small class="fw-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</small></td>
                                <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                                <td><span class="badge bg-secondary">Jam {{ $item->jam_ke }}</span></td>
                                <td><small class="text-muted">{{ $item->guru->nama ?? '-' }}</small></td>
                                <td>
                                    @if($item->status === 'Masuk')
                                        <span class="badge badge-masuk">Masuk</span>
                                    @elseif($item->status === 'Izin')
                                        <span class="badge badge-izin">Izin</span>
                                    @elseif($item->status === 'Sakit')
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
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                    Belum ada data kehadiran yang tercatat untuk Anda.
                </div>
                @endif
            </div>
        </div>

        <!-- Catatan Kedisiplinan / Pelanggaran Siswa -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100">
                <h5 class="fw-bold mb-3 text-dark">
                    <i class="bi bi-shield-check text-success me-2"></i> Catatan Kedisiplinan
                </h5>

                @if(isset($pelanggaran) && $pelanggaran->count() > 0)
                    <div class="alert alert-warning small mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Anda memiliki {{ $pelanggaran->count() }} catatan kedisiplinan. Mohon tingkatkan ketertiban.
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($pelanggaran as $p)
                        <li class="list-group-item px-0 py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">{{ $p->jenis }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1 small text-dark">{{ $p->keterangan ?? 'Tidak ada catatan tambahan' }}</p>
                            @if($p->tindakan)
                                <small class="text-success"><i class="bi bi-check2 me-1"></i>Tindakan: {{ $p->tindakan }}</small>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-award-fill text-warning" style="font-size: 4rem;"></i>
                        <h6 class="fw-bold text-success mt-3 mb-1">Catatan Bersih!</h6>
                        <p class="text-muted small mb-0">Tidak ada catatan pelanggaran atau ketidaktertiban. Pertahankan prestasi dan kedisiplinanmu!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

