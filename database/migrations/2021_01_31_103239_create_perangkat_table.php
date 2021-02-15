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
            $table->string('sn_lama')->unique();
            $table->bigInteger('tipe_perangkat');
            $table->string('sn_pengganti')->unique();
            $table->string('sn_monitor')->unique()->nullable();
            $table->bigInteger('nik_user');
            $table->bigInteger('id_image');
            $table->bigInteger('id_witel');
            $table->bigInteger('id_do')->nullable();
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
