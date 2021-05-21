<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengiriman')->insert([
            [
                'no_pengiriman' => 'DO-501562',
                'id_cabang' => '1',
                'tanggal_pengiriman' => '2021-04-03 22:08:50',
                'created_at' => '2021-04-11 15:32:49',
            ],
            [
                'no_pengiriman' => 'DO-501563',
                'id_cabang' => '2',
                'tanggal_pengiriman' => '2021-04-04 22:08:50',
                'created_at' => '2021-04-12 15:32:49',
            ],
            [
                'no_pengiriman' => 'DO-501564',
                'id_cabang' => '2',
                'tanggal_pengiriman' => '2021-04-05 22:08:50',
                'created_at' => '2021-04-13 15:32:49',
            ],
        ]);
    }
}
