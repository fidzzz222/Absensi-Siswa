<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('absensi_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_pelajaran_id')->constrained('jadwal_pelajaran')->cascadeOnDelete();
            $table->date('tanggal');
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete(); // guru yg mencatat
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Pastikan hanya satu absensi per jadwal per tanggal
            $table->unique(['jadwal_pelajaran_id','tanggal'], 'unique_absensi_per_jadwal_tanggal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi_pelajaran');
    }
};
