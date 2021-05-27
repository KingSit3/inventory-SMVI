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
            $table->string('sn_pengganti')->unique();
            $table->string('sn_monitor')->unique()->nullable();
            $table->unsignedBigInteger('id_tipe')->index();
            $table->unsignedBigInteger('id_user')->nullable()->index();
            $table->unsignedBigInteger('id_sistem')->index();
            $table->unsignedBigInteger('id_cabang')->nullable()->index();
            $table->unsignedBigInteger('id_pengiriman')->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->string('cek_status')->nullable();
            $table->string('perolehan')->nullable();
            $table->unsignedBigInteger('gelombang')->nullable()->index();
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
