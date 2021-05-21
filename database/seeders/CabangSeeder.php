<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cabang')->insert([
            [
                'nama_cabang' => 'REG 02',
                'kode_cabang' => 'R02',
                'regional' => '2',
                'alamat_cabang' => 'IS Service Support GMP Telkom lt. M, Jl. Gatot Subroto Kav.52',
                'id_pic' => '1',
            ],
            [
                'nama_cabang' => 'MADURA',
                'kode_cabang' => 'P55',
                'regional' => '5',
                'alamat_cabang' => 'l. P. Trunojoyo No.67, Barurambat Kota, Pamekasan, 69313',
                'id_pic' => '4',
            ],
        ]);
    }
}
