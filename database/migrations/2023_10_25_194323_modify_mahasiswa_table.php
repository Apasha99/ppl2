<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('alamat', 100)->nullable()->change();
            $table->string('kabkota', 100)->nullable()->change();
            $table->string('provinsi', 100)->nullable()->change();
            $table->string('noHandphone', 20)->nullable()->change();
            $table->string('fotoProfil', 100)->nullable()->change();
        });
    }

    public function down()
    {
        // Untuk mengembalikan perubahan jika diperlukan
    }
}

