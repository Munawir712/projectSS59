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
        Schema::create('kosan_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kosan_id');
            $table->string('filename');
            $table->string('image_url');
            $table->timestamps();

            $table->foreign('kosan_id')->references('id')->on('kosans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kosan_images');
    }
};
