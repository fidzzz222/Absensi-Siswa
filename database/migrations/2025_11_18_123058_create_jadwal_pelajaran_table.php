<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->foreignId('jam_pelajaran_id')->constrained('jam_pelajaran')->cascadeOnDelete();
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'])->default('Senin');
            // optional: teacher assignment
            $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete(); // guru pengajar
            $table->timestamps();

            $table->unique(['mata_pelajaran_id','kelas_id','jam_pelajaran_id','hari'], 'jadwal_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};
