<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $fillable = [
        'siswa_id', 'guru_id', 'mapel_id', 'kelas_id', 'tanggal', 'jam_ke', 'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function jamPelajaran()
    {
        return $this->belongsTo(JamPelajaran::class, 'jam_ke', 'jam_ke');
    }
}
