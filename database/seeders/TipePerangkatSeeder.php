<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipePerangkatSeeder extends Seeder
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
                'tipe_perangkat' => 'Laptop',
                'kode_perangkat' => 'MPRO',
            ],
            [
                'nama_perangkat' => 'MacBook Air ',
                'tipe_perangkat' => 'Laptop',
                'kode_perangkat' => 'MAIR',
            ],
            [
                'nama_perangkat' => 'PC HP',
                'tipe_perangkat' => 'Komputer',
                'kode_perangkat' => 'KOMPHP',
            ],
            [
                'nama_perangkat' => 'Projector BenQ',
                'tipe_perangkat' => 'Projector',
                'kode_perangkat' => 'PTR',
            ],
        ]);
    }
}
