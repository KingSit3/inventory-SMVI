<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerangkatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perangkat', function (Blueprint $table) {
            $table->id();
            $table->string('sn_lama')->unique()->nullable();
            $table->string('tipe_perangkat');
            $table->string('sn_pengganti')->unique();
            $table->string('sn_monitor')->unique()->nullable();
            $table->bigInteger('id_user')->nullable();
            $table->string('kode_image');
            $table->string('kode_witel')->nullable();
            $table->string('no_do')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('perangkat');
    }
}
