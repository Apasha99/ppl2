<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('khs', function (Blueprint $table) {
            $table->increments('idkhs');
            $table->integer('semester_aktif');
            $table->integer('jumlah_sks');
            $table->string('scanKHS');
            $table->unsignedDouble('ip_semester');
            $table->unsignedDouble('ip_kumulatif');
            $table->string('status');
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('dosen_wali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
