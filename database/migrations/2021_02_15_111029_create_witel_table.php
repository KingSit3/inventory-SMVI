<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWitelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('witel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_witel');
            $table->string('kode_witel');
            $table->string('regional');
            $table->string('alamat_witel');
            $table->string('pic');
            $table->string('kode_pic');
            $table->string('no_telp_pic');
            $table->softDeletes();
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
        Schema::dropIfExists('witel');
    }
}
