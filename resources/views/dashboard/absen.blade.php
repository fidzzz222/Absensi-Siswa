@extends('layouts.app')

@section('title', 'Rekap Kehadiran Siswa')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Rekap Kehadiran Siswa</h3>
            <p class="text-muted mb-0">Pantau seluruh catatan presensi siswa, saring berdasarkan kelas, tanggal, status, atau cari nama siswa.</p>
        </div>
        @if(in_array(auth()->user()->role, ['guru_mapel', 'sekretaris']))
        <a href="{{ route('guru.absen.form') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Input Absensi Baru
        </a>
        @endif
    </div>

    <!-- FILTER CARD -->
    <div class="card-custom p-4 mb-4">
        <form method="GET" action="{{ route('dashboard.absen') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary">Cari Siswa / NISN</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Nama atau NISN..." value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-semibold text-secondary">Kelas</label>
                <select name="kelas_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-semibold text-secondary">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-semibold text-secondary">Jam Ke</label>
                <select name="jam_ke" class="form-select">
                    <option value="">Semua Jam</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('jam_ke') == $i ? 'selected' : '' }}>Jam {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small fw-semibold text-secondary">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Masuk" {{ request('status') == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Alfa" {{ request('status') == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>

            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3" title="Terapkan Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if(request()->hasAny(['q', 'kelas_id', 'tanggal', 'jam_ke', 'status']))
                <a href="{{ route('dashboard.absen') }}" class="btn btn-outline-secondary py-2 rounded-3" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="card-custom p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-card-list text-primary me-2"></i> Data Presensi
                </h5>
                <small class="text-muted">Menampilkan {{ $results->total() }} catatan presensi ditemukan</small>
            </div>
        </div>

        @if($results->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-3">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Jam Ke</th>
                        <th>Guru Pengajar</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $row)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ $results->firstItem() + $index }}
                        </td>
                        <td><small class="fw-semibold">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</small></td>
                        <td><span class="badge bg-light text-dark border">{{ $row->siswa->nisn ?? '-' }}</span></td>
                        <td class="fw-semibold">{{ $row->siswa->nama ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $row->siswa->kelas->nama_kelas ?? ($row->kelas->nama_kelas ?? '-') }}</span></td>
                        <td><small>{{ $row->mapel->nama_mapel ?? '-' }}</small></td>
                        <td><span class="badge bg-secondary">Jam {{ $row->jam_ke }}</span></td>
                        <td><small class="text-muted">{{ $row->guru->nama ?? '-' }}</small></td>
                        <td class="text-center">
                            @if($row->status === 'Masuk')
                                <span class="badge badge-masuk px-3 py-2">Masuk</span>
                            @elseif($row->status === 'Izin')
                                <span class="badge badge-izin px-3 py-2">Izin</span>
                            @elseif($row->status === 'Sakit')
                                <span class="badge badge-sakit px-3 py-2">Sakit</span>
                            @else
                                <span class="badge badge-alfa px-3 py-2">Alfa</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Halaman {{ $results->currentPage() }} dari {{ $results->lastPage() }}
            </small>
            <div>
                {{ $results->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 text-secondary d-block mb-2"></i>
            <h5>Data Tidak Ditemukan</h5>
            <p class="small mb-0">Coba ubah kata kunci pencarian atau sesuaikan filter Anda.</p>
        </div>
        @endif
    </div>
</div>
@endsection

