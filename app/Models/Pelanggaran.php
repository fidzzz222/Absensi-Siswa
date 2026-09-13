<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'pencatat_id',
        'tanggal',
        'jenis',
        'keterangan',
        'ditangani_oleh',
        'tindakan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'pencatat_id');
    }

    public function penangan()
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}
