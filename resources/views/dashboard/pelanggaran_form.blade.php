@extends('layouts.app')

@section('title', 'Catat Pelanggaran / Keterlambatan Siswa')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Form Catatan Kedisiplinan</h3>
            <p class="text-muted mb-0">Catat keterlambatan, ketidaktertiban seragam, membolos, atau pelanggaran tata tertib lainnya.</p>
        </div>
        <a href="{{ route('pelanggaran.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom p-4">
                <form action="{{ route('pelanggaran.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Pilih Siswa <span class="text-danger">*</span></label>
                        <select name="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Nama Siswa --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->id }}" {{ (request('siswa_id') == $s->id || old('siswa_id') == $s->id) ? 'selected' : '' }}>
                                    {{ $s->nama }} (NISN: {{ $s->nisn }}) - Kelas {{ $s->kelas->nama_kelas ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Tanggal Kejadian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $today) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <input list="jenisList" name="jenis" class="form-control" placeholder="Pilih atau ketik jenis..." value="{{ old('jenis') }}" required>
                            <datalist id="jenisList">
                                <option value="Terlambat Masuk Sekolah">
                                <option value="Membolos / Keluar Tanpa Izin">
                                <option value="Tidak Mengenakan Atribut Lengkap">
                                <option value="Seragam Tidak Sesuai Ketentuan">
                                <option value="Penggunaan Handphone Tanpa Izin Guru">
                                <option value="Rambut / Kerapian Tidak Sesuai Aturan">
                                <option value="Merokok / Membawa Rokok">
                                <option value="Tindakan Tidak Sopan Terhadap Guru/Siswa">
                            </datalist>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Keterangan / Kronologi Kejadian</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Datang pukul 07.25 WIB dengan alasan ban motor bocor...">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Tindakan / Pembinaan yang Diberikan</label>
                        <input type="text" name="tindakan" class="form-control" placeholder="Contoh: Diberi teguran lisan, pembinaan piket, atau pemanggilan orang tua" value="{{ old('tindakan') }}">
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <a href="{{ route('pelanggaran.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold rounded-pill shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Catatan Pelanggaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
