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
        Schema::create('skripsi', function (Blueprint $table) {
            $table->increments('idskripsi');
            $table->integer('semester_aktif');
            $table->string('statusSkripsi');
            $table->string('scanSkripsi');
            $table->string('status');
            $table->string('nim');
            $table->string('nip');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};
