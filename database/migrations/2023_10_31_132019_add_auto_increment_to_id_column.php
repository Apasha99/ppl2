<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoIncrementToIdColumn extends Migration
{
    public function up()
    {
        Schema::table('pkl', function (Blueprint $table) {
            $table->id(); // Ini akan mengatur kolom 'id' sebagai auto-increment.
        });
    }

    public function down()
    {
        Schema::table('pkl', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
