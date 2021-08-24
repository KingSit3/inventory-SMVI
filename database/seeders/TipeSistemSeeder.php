<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipe_sistem')->insert([
            [
                'kode_sistem' => 'GCS1',
            ],
            [
                'kode_sistem' => 'GCS2',
            ],
            [
                'kode_sistem' => 'BFR1',
            ],
        ]);
    }
}
