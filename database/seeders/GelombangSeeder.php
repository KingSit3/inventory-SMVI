<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GelombangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gelombang')->insert([
            [
                'nama_gelombang' => '1',
            ],
            [
                'nama_gelombang' => '2',
            ],
            [
                'nama_gelombang' => '3',
            ],
        ]);
    }
}
