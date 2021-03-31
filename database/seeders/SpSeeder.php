<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sp')->insert([
            [
                'nama_sp' => '1',
            ],
            [
                'nama_sp' => '2',
            ],
            [
                'nama_sp' => '3',
            ],
        ]);
    }
}
