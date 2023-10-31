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
        Schema::create('pkl', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('id');
            $table->string('nim');
            $table->string('status_pkl');
            $table->string('scan_pkl');

            $table->timestamp('created_at')->userCurrent();
            $table->timestamp('updated_at')->userCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pkl');
    }
};

?>