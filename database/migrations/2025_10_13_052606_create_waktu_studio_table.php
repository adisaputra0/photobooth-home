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
        Schema::create('waktu_studio', function (Blueprint $table) {
            $table->id();
            $table->date("tanggal");
            $table->integer("waktu_awal");
            $table->integer("waktu_akhir");
            $table->string("status"); // buka / tutup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_studio');
    }
};
