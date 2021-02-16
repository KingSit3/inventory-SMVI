<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipePerangkat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_perangkat')->insert([
            [
                'nama_perangkat' => 'MacBook Pro',
                'tipe_perangkat' => 'KOM',
                'kode_perangkat' => 'NBE-A',
            ],
            [
                'nama_perangkat' => 'MacBook Air ',
                'tipe_perangkat' => 'KOM',
                'kode_perangkat' => 'NB1-A',
            ],
            [
                'nama_perangkat' => 'PC HP',
                'tipe_perangkat' => 'KOM',
                'kode_perangkat' => 'PC',
            ],
            [
                'nama_perangkat' => 'Projector',
                'tipe_perangkat' => 'INF',
                'kode_perangkat' => 'MOB',
            ],
        ]);
    }
}
