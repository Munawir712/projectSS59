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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('desc');
            $table->timestamps();
        });

        Schema::create('kosan_facilities', function (Blueprint $table) {
            $table->unsignedBigInteger('kosan_id');
            $table->unsignedBigInteger('facility_id');
            $table->timestamps();

            $table->foreign('kosan_id')->references('id')->on('kosans')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('kosan_facilities');
    }
};
