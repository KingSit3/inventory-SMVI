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
                'nama_cabang' => 'Jakarta',
                'kode_cabang' => 'JKT',
                'regional' => '2',
                'alamat_cabang' => 'IS Service Support GMP Telkom',
                'id_pic' => '1',
            ],
            [
                'nama_cabang' => 'MADURA',
                'kode_cabang' => 'MDR',
                'regional' => '3',
                'alamat_cabang' => 'l. P. Trunojoyo No.67, Barurambat Kota',
                'id_pic' => '4',
            ],
        ]);
    }
}
