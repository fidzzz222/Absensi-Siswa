<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_pelajaran_id')->constrained('absensi_pelajaran')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->enum('status', ['Masuk','Izin','Sakit','Alfa'])->default('Masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Optional: satu siswa hanya satu baris per absensi_pelajaran
            $table->unique(['absensi_pelajaran_id','siswa_id'], 'unique_detail_per_absensi_siswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_absensi');
    }
};
