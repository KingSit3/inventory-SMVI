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
                'kode_sistem' => 'GEN',
            ],
            [
                'kode_sistem' => 'FIN3',
            ],
            [
                'kode_sistem' => 'FIN4',
            ],
        ]);
    }
}
