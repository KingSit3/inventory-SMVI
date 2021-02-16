<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WitelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('witel')->insert([
            [
                'nama_witel' => 'REG 02',
                'kode_witel' => 'R02',
                'regional' => '2',
                'alamat_witel' => 'IS Service Support GMP Telkom lt. M, Jl. Gatot Subroto Kav.52',
                'nik_pic' => '670472',
            ],
            [
                'nama_witel' => 'MADURA',
                'kode_witel' => 'P55',
                'regional' => '5',
                'alamat_witel' => 'l. P. Trunojoyo No.67, Barurambat Kota, Pamekasan, 69313',
                'nik_pic' => '670472',
            ],
        ]);
    }
}
