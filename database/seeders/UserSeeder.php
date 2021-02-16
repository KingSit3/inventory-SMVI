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
                'name' => 'PrasetyoWidodo',
                'nik' => '231342',
                'no_telp' => '62 811373790',
            ],
            [
                'name' => 'HERU PRAYOGO',
                'nik' => '850020',
                'no_telp' => '0811 522 125',
            ],
            [
                'name' => 'DWI EKO TRI SAPTONO',
                'nik' => '631818',
                'no_telp' => '',
            ],
        ]);
    }
}
