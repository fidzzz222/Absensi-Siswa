<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\JamPelajaran;
use App\Models\Absensi;
use App\Models\Pelanggaran;
use Carbon\Carbon;

class SiHadirFullSystemTest extends TestCase
{
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_at_root_redirects_to_their_dashboard()
    {
        $guruUser = User::where('role', 'guru_mapel')->first();
        $response = $this->actingAs($guruUser)->get('/');
        $response->assertRedirect('/dashboard/guru');
    }

    public function test_login_page_renders_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Si Hadir');
        $response->assertSee('SMKN 1 Kota Bekasi');
    }

    public function test_guru_login_and_dashboard()
    {
        $guruUser = User::where('role', 'guru_mapel')->first();
        $this->assertNotNull($guruUser);

        $loginResponse = $this->post('/login', [
            'email' => $guruUser->email,
            'password' => '123456',
        ]);

        $loginResponse->assertRedirect('/dashboard/guru');

        $dashResponse = $this->actingAs($guruUser)->get('/dashboard/guru');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Panel Guru Pengajar');
    }

    public function test_siswa_login_and_dashboard()
    {
        $siswaUser = User::where('role', 'siswa')->first();
        $this->assertNotNull($siswaUser);

        $dashResponse = $this->actingAs($siswaUser)->get('/dashboard/siswa');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Portal Siswa');
    }

    public function test_sekretaris_dashboard()
    {
        $user = User::where('role', 'sekretaris')->first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get('/dashboard/sekretaris');
        $response->assertStatus(200);
        $response->assertSee('Presensi Kelas');
    }

    public function test_guru_bk_dashboard()
    {
        $user = User::where('role', 'guru_bk')->first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get('/dashboard/guru-bk');
        $response->assertStatus(200);
        $response->assertSee('Layanan Bimbingan Konseling');
    }

    public function test_guru_piket_dashboard()
    {
        $user = User::where('role', 'guru_piket')->first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get('/dashboard/guru-piket');
        $response->assertStatus(200);
        $response->assertSee('Piket Harian');
    }

    public function test_form_guru_loads_with_class()
    {
        $user = User::where('role', 'guru_mapel')->first();
        $response = $this->actingAs($user)->get('/dashboard/guru/absen?kelas_id=1');
        $response->assertStatus(200);
        $response->assertSee('Lembar Kehadiran Siswa');
    }

    public function test_store_attendance()
    {
        $guruUser = User::where('role', 'guru_mapel')->first();
        $guru = Guru::first();
        $mapel = Mapel::first();
        $kelas = Kelas::first();
        $siswa = Siswa::first();
        $today = Carbon::today()->toDateString();

        $response = $this->actingAs($guruUser)->post('/dashboard/guru/absen/store', [
            'guru_id' => $guru->id,
            'mapel_id' => $mapel->id,
            'kelas_id' => $kelas->id,
            'tanggal' => $today,
            'jam_ke' => 1,
            'status' => [
                $siswa->id => 'Masuk',
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('absensi', [
            'siswa_id' => $siswa->id,
            'mapel_id' => $mapel->id,
            'jam_ke' => 1,
            'tanggal' => $today,
            'status' => 'Masuk',
        ]);
    }

    public function test_rekap_absensi_page()
    {
        $user = User::where('role', 'guru_mapel')->first();
        $response = $this->actingAs($user)->get('/dashboard/absen');
        $response->assertStatus(200);
        $response->assertSee('Rekap Kehadiran Siswa');
    }

    public function test_pelanggaran_flow()
    {
        $user = User::where('role', 'guru_bk')->first();
        $siswa = Siswa::first();

        // Index
        $indexResponse = $this->actingAs($user)->get('/dashboard/pelanggaran');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Buku Catatan Kedisiplinan Siswa');

        // Create form
        $createResponse = $this->actingAs($user)->get('/dashboard/pelanggaran/create');
        $createResponse->assertStatus(200);

        // Store
        $storeResponse = $this->actingAs($user)->post('/dashboard/pelanggaran', [
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jenis' => 'Terlambat Masuk Sekolah',
            'keterangan' => 'Ban motor bocor',
            'tindakan' => 'Diberikan teguran lisan',
        ]);

        $storeResponse->assertRedirect('/dashboard/pelanggaran');
        $this->assertDatabaseHas('pelanggaran', [
            'siswa_id' => $siswa->id,
            'jenis' => 'Terlambat Masuk Sekolah',
        ]);
    }
}
