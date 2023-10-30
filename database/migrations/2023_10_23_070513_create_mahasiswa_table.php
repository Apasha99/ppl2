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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nama', 100);
            $table->string('nim', 20)->primary();
            $table->integer('angkatan');
            $table->string('status', 20);
            $table->string('alamat', 100);
            $table->string('kabkota', 100);
            $table->string('provinsi', 100);
            $table->string('username')->unique();
            $table->string('password');
            $table->string('noHandphone', 20);
            $table->string('fotoProfil', 100);
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
        Schema::dropIfExists('mahasiswa');
    }
};
