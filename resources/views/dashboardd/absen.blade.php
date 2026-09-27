@extends('layouts.app')

@section('title', 'Input Absensi Siswa')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">Form Presensi Siswa</h3>
            <p class="text-muted mb-0">Pilih parameter kelas, mata pelajaran, dan jam pelajaran untuk memulai penginputan absensi.</p>
        </div>
        <a href="{{ route('dashboard.absen') }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-table me-1"></i> Rekap Absensi
        </a>
    </div>

    <!-- CARD FORM PARAMETER -->
    <div class="card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-sliders text-primary me-2"></i> Parameter Pembelajaran
        </h5>

        <form method="GET" action="{{ route('guru.absen.form') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Guru Pengajar <span class="text-danger">*</span></label>
                    <select name="guru_id" class="form-select" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id }}" {{ (request('guru_id', $currentGuru?->id ?? '') == $g->id || (old('guru_id') == $g->id)) ? 'selected' : '' }}>
                                {{ $g->nama }} ({{ $g->nip ?? 'Guru' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Mata Pelajaran <span class="text-danger">*</span></label>
                    <select name="mapel_id" class="form-select" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ (request('mapel_id') == $m->id || (old('mapel_id') == $m->id)) ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Kelas / Rombel <span class="text-danger">*</span></label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ (request('kelas_id', $selectedKelasId ?? '') == $k->id || (old('kelas_id') == $k->id)) ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Tanggal Presensi <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', $tanggalDipilih) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-secondary">Jam Pelajaran Ke <span class="text-danger">*</span></label>
                    <select name="jam_ke" class="form-select" required>
                        <option value="">-- Pilih Jam Pelajaran --</option>
                        @foreach ($jam as $j)
                            <option value="{{ $j->jam_ke }}" {{ (request('jam_ke') == $j->jam_ke || old('jam_ke') == $j->jam_ke) ? 'selected' : '' }}>
                                Jam Ke-{{ $j->jam_ke }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill">
                    <i class="bi bi-people-fill me-1"></i> Muat Daftar Siswa
                </button>
            </div>
        </form>
    </div>

    <!-- DAFTAR SISWA UNTUK ABSENSI -->
    @if(!empty($data_siswa) && count($data_siswa) > 0)
    <div class="card-custom p-4">
        <form method="POST" action="{{ route('guru.absen.store') }}" id="absenForm">
            @csrf
            <input type="hidden" name="guru_id" value="{{ request('guru_id', $currentGuru?->id ?? '') }}">
            <input type="hidden" name="mapel_id" value="{{ request('mapel_id') }}">
            <input type="hidden" name="kelas_id" value="{{ request('kelas_id', $selectedKelasId ?? '') }}">
            <input type="hidden" name="tanggal" value="{{ request('tanggal', $tanggalDipilih) }}">
            <input type="hidden" name="jam_ke" value="{{ request('jam_ke') }}">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-card-checklist text-success me-2"></i> Lembar Kehadiran Siswa
                    </h5>
                    <small class="text-muted">Total: {{ count($data_siswa) }} siswa terdaftar di kelas ini</small>
                </div>

                <!-- Quick Button Set Status -->
                <div class="d-flex gap-2 flex-wrap">
                    <span class="small text-muted align-self-center me-1">Set Semua:</span>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="setAllStatus('Masuk')">
                        <i class="bi bi-check-all"></i> Semua Masuk
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="setAllStatus('Izin')">
                        Semua Izin
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3" onclick="setAllStatus('Sakit')">
                        Semua Sakit
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="setAllStatus('Alfa')">
                        Semua Alfa
                    </button>
                </div>
            </div>

            @if(count($existing_status) > 0)
            <div class="alert alert-info py-2 px-3 small rounded-3 mb-3">
                <i class="bi bi-info-circle-fill me-2"></i> Data absensi untuk sesi ini sudah pernah disimpan sebelumnya. Anda dapat mengubah dan menyimpannya kembali.
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-4">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;" class="text-center">No</th>
                            <th style="width: 130px;">NISN</th>
                            <th>Nama Siswa</th>
                            <th style="width: 80px;" class="text-center">L/P</th>
                            <th style="width: 320px;" class="text-center">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_siswa as $idx => $siswa)
                        @php
                            $sudahDiabsenSesiIni = isset($existing_status[$siswa->id]);
                            $catatanSebelumnya = $catatan_harian[$siswa->id] ?? null;
                            $isTelatPiket = isset($terlambat_today) && in_array($siswa->id, $terlambat_today);

                            // Jika belum pernah diabsen di jam ini, tapi ada info Sakit/Izin hari ini dari sesi sebelumnya/sekretaris
                            $currentStatus = $sudahDiabsenSesiIni 
                                ? $existing_status[$siswa->id] 
                                : ($catatanSebelumnya ?? 'Masuk');
                        @endphp
                        <tr>
                            <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $siswa->nisn }}</span></td>
                            <td class="fw-semibold">
                                {{ $siswa->nama }}
                                @if($isTelatPiket)
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle ms-1" title="Tercatat terlambat di piket gerbang hari ini">
                                        <i class="bi bi-clock-history me-1"></i>Telat Piket
                                    </span>
                                @endif
                                @if($catatanSebelumnya && !$sudahDiabsenSesiIni)
                                    <span class="badge bg-info-subtle text-info border border-info-subtle ms-1" title="Tercatat {{ $catatanSebelumnya }} pada sesi sebelumnya hari ini">
                                        <i class="bi bi-info-circle me-1"></i>Info: {{ $catatanSebelumnya }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $siswa->jenis_kelamin == 'L' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check status-radio" name="status[{{ $siswa->id }}]" id="masuk_{{ $siswa->id }}" value="Masuk" {{ $currentStatus == 'Masuk' ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-success" for="masuk_{{ $siswa->id }}">Masuk</label>

                                    <input type="radio" class="btn-check status-radio" name="status[{{ $siswa->id }}]" id="izin_{{ $siswa->id }}" value="Izin" {{ $currentStatus == 'Izin' ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-warning" for="izin_{{ $siswa->id }}">Izin</label>

                                    <input type="radio" class="btn-check status-radio" name="status[{{ $siswa->id }}]" id="sakit_{{ $siswa->id }}" value="Sakit" {{ $currentStatus == 'Sakit' ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-info" for="sakit_{{ $siswa->id }}">Sakit</label>

                                    <input type="radio" class="btn-check status-radio" name="status[{{ $siswa->id }}]" id="alfa_{{ $siswa->id }}" value="Alfa" {{ $currentStatus == 'Alfa' ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-danger" for="alfa_{{ $siswa->id }}">Alfa</label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <span class="text-muted small">Pastikan semua data kehadiran sudah tepat sebelum menekan tombol simpan.</span>
                <button type="submit" class="btn btn-success px-4 py-2 fw-semibold rounded-pill shadow-sm">
                    <i class="bi bi-cloud-check-fill me-1"></i> Simpan Data Presensi
                </button>
            </div>
        </form>
    </div>
    @elseif(request('kelas_id'))
    <div class="card-custom p-5 text-center text-muted">
        <i class="bi bi-people fs-1 text-secondary d-block mb-2"></i>
        <h5>Belum Ada Siswa di Kelas Ini</h5>
        <p class="small mb-0">Silakan pilih kelas lain atau periksa data siswa master.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function setAllStatus(val) {
        document.querySelectorAll(`.status-radio[value="${val}"]`).forEach(el => {
            el.checked = true;
        });
    }
</script>
@endpush
@endsection

