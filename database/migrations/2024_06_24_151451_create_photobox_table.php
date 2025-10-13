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
        Schema::create('photobox', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->integer("jumlah_orang");
            $table->date("tanggal");
            $table->string("waktu");
            $table->string("penambahan_waktu")->nullable();
            $table->integer("jumlah_bando")->nullable();
            $table->string("nomor_telp");
            $table->string("kendaraan");
            $table->string("note");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photobox');
    }
};
