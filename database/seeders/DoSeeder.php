<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_do')->insert([
            [
                'no_do' => 'DO-501562',
                'id_witel' => '1',
                'tanggal_do' => '2021-04-03 22:08:50',
            ],
            [
                'no_do' => 'DO-501563',
                'id_witel' => '4',
                'tanggal_do' => '2021-04-04 22:08:50',
            ],
            [
                'no_do' => 'DO-501564',
                'id_witel' => '2',
                'tanggal_do' => '2021-04-05 22:08:50',
            ],
        ]);
    }
}
