<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('image')->insert([
            [
                'kode_image' => 'GEN',
            ],
            [
                'kode_image' => 'FIN3',
            ],
            [
                'kode_image' => 'FIN4',
            ],
        ]);
    }
}
