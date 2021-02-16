<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'SUPRIYANTO',
                'nik' => '670472',
                'no_telp' => '081212103633',
            ],
            [
                'name' => 'SUPRIYANTO',
                'nik' => '670472',
                'no_telp' => '081212103633',
            ],
        ]);
    }
}
