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
                'nama' => 'SUPRIYANTO',
                'nik' => '670472',
                'no_telp' => '081212103633',
            ],
            [
                'nama' => 'PrasetyoWidodo',
                'nik' => null,
                'no_telp' => '62 811373790',
            ],
            [
                'nama' => 'HERU PRAYOGO',
                'nik' => '850020',
                'no_telp' => '0811 522 125',
            ],
            [
                'nama' => 'DWI EKO TRI SAPTONO',
                'nik' => '631818',
                'no_telp' => '',
            ],
        ]);
    }
}
