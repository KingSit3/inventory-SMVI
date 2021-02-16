<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perangkat')->insert([
            [
                'sn_lama' => '1SBJCK34400619',
                'tipe_perangkat' => 'NBE-A',
                'sn_pengganti' => 'FVFZJ3YFL410',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => 'GEN',
                'kode_witel' => 'R02',
                'no_do' => null,
                'keterangan' => null,
            ],
        ]);
    }
}
