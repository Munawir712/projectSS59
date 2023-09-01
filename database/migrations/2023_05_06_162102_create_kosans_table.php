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
        Schema::create('kosans', function (Blueprint $table) {
            $table->id();
            $table->string('no_kamar');
            $table->string('name');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('category');
            $table->integer('max_orang');
            $table->integer('jumlah_kos');
            $table->string('tipe')->default('KAMAR');
            $table->string('gender_category');
            $table->text('description')->nullable();
            $table->enum('status', ['tersedia', 'disewa', 'perbaikan', 'tidak_tersedia'])->default('tersedia');
            $table->integer('harga');
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
        Schema::dropIfExists('kosans');
    }
};
