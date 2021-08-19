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
                'sn_lama' => '1SBKFHND4400619',
                'sn_pengganti' => 'FVF93JBFFL410',
                'sn_monitor' => null,
                'id_tipe' => '1',
                'id_user' => '1',
                'id_sistem' => '1',
                'id_cabang' => '1',
                'id_pengiriman' => '1',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'gelombang' => '3',
            ],
            [
                'sn_lama' => null,
                'id_tipe' => '2',
                'sn_pengganti' => 'FVF8FHV5L410',
                'sn_monitor' => null,
                'id_user' => '1',
                'id_sistem' => '3',
                'id_cabang' => '2',
                'id_pengiriman' => '2',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'gelombang' => '1',
            ],
            [
                'sn_lama' => null,
                'id_tipe' => '3',
                'sn_pengganti' => 'FVKDHLSHJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'id_sistem' => '1',
                'id_cabang' => '2',
                'id_pengiriman' => null,
                'keterangan' => 'Tambahan',
                'cek_status' => 'NCS',
                'perolehan' => 'NCD',
                'gelombang' => '2',
            ],
            [
                'sn_lama' => null,
                'id_tipe' => '1',
                'sn_pengganti' => 'FVFY95KFJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'id_sistem' => '2',
                'id_cabang' => '1',
                'id_pengiriman' => '3',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'gelombang' => '1',
            ],
            [
                'sn_lama' => 'SGHLFJNYSV',
                'id_tipe' => '2',
                'sn_pengganti' => '8CG058HHQ7',
                'sn_monitor' => '3CKDH517GQ',
                'id_user' => '3',
                'id_sistem' => '2',
                'id_cabang' => '1',
                'id_pengiriman' => '2',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'gelombang' => '2',
            ],
            [
                'sn_lama' => null,
                'id_tipe' => '3',
                'sn_pengganti' => '8C84JG1HMZ',
                'sn_monitor' => '3CQ903KBM0',
                'id_user' => '3',
                'id_sistem' => '1',
                'id_cabang' => '1',
                'id_pengiriman' => null,
                'keterangan' => 'tambahan',
                'cek_status' => 'NPS',
                'perolehan' => 'NCD',
                'gelombang' => '1',
            ],
        ]);
    }
}
