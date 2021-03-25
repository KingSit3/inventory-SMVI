<?php

namespace Database\Seeders;

use App\Models\Image;
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
        Image::factory(100)->create();

        // DB::table('image')->insert([
        //     [
        //         'kode_image' => 'GEN',
        //     ],
        //     [
        //         'kode_image' => 'FIN3',
        //     ],
        //     [
        //         'kode_image' => 'FIN4',
        //     ],
        // ]);
    }
}
