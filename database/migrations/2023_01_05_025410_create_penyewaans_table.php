<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();
            $table->integer('penyewa_id');
            $table->integer('kosan_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_sewa');
            $table->integer('jumlah_orang');
            $table->enum('status', ['belum_dikonfirmasi', 'menunggu_pembayaran',  'dikonfirmasi', 'sedang_disewa', 'selesai', 'dibatalkan', 'belum_bayar', 'dalam_proses'])->default('belum_dikonfirmasi');
            $table->boolean('confirmed')->default(false);
            $table->integer('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyewaans');
    }
};
