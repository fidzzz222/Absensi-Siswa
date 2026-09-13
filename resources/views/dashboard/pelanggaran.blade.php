@extends('layouts.app')

@section('title', 'Catatan Pelanggaran & Kedisiplinan')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Buku Catatan Kedisiplinan Siswa</h3>
            <p class="text-muted mb-0">Kelola dan pantau catatan keterlambatan, ketertiban, dan pembinaan siswa secara terpusat.</p>
        </div>
        <a href="{{ route('pelanggaran.create') }}" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Catat Kasus / Pelanggaran Baru
        </a>
    </div>

    <!-- FILTER CARD -->
    <div class="card-custom p-4 mb-4">
        <form method="GET" action="{{ route('pelanggaran.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-secondary">Cari Siswa / Kasus</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Nama, NISN, atau jenis kasus..." value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-3">
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

            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary">Tanggal Kejadian</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->hasAny(['q', 'kelas_id', 'tanggal']))
                <a href="{{ route('pelanggaran.index') }}" class="btn btn-outline-secondary py-2 rounded-3" title="Reset">
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
                    <i class="bi bi-shield-exclamation text-danger me-2"></i> Daftar Catatan Pelanggaran
                </h5>
                <small class="text-muted">Total: {{ $pelanggaran->total() }} catatan terdata</small>
            </div>
        </div>

        @if($pelanggaran->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-3">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Keterangan</th>
                        <th>Tindakan / Pembinaan</th>
                        <th>Pencatat</th>
                        <th class="text-center" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggaran as $index => $row)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ $pelanggaran->firstItem() + $index }}
                        </td>
                        <td><small class="fw-semibold">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</small></td>
                        <td>
                            <div class="fw-semibold">{{ $row->siswa->nama ?? '-' }}</div>
                            <small class="text-muted">{{ $row->siswa->nisn ?? '-' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $row->siswa->kelas->nama_kelas ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                {{ $row->jenis }}
                            </span>
                        </td>
                        <td><small class="text-secondary">{{ $row->keterangan ?? '-' }}</small></td>
                        <td>
                            @if($row->tindakan)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    {{ $row->tindakan }}
                                </span>
                            @else
                                <span class="text-muted small">Belum ada</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $row->pencatat->name ?? 'Petugas' }}</small></td>
                        <td class="text-center">
                            <form action="{{ route('pelanggaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pelanggaran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Catatan">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Halaman {{ $pelanggaran->currentPage() }} dari {{ $pelanggaran->lastPage() }}
            </small>
            <div>
                {{ $pelanggaran->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-check2-circle fs-1 text-success d-block mb-2"></i>
            <h5>Tidak Ada Catatan Pelanggaran</h5>
            <p class="small mb-0">Tidak ada riwayat pelanggaran yang sesuai dengan kriteria filter.</p>
        </div>
        @endif
    </div>
</div>
@endsection
