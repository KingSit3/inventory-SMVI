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
                'no_do' => 'DO-501564',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '4',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => 'NBE-A',
                'sn_pengganti' => 'FVFZJ475L410',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => 'GEN',
                'kode_witel' => 'R02',
                'no_do' => 'DO-501564',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '4',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => 'NB1-A',
                'sn_pengganti' => 'FVFYR2SHJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => 'FIN4',
                'kode_witel' => 'R02',
                'no_do' => null,
                'keterangan' => 'Tambahan',
                'cek_status' => 'NCS',
                'perolehan' => 'NCD',
                'sp' => '5',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => 'NB1-A',
                'sn_pengganti' => 'FVFYR2RHJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => 'FIN4',
                'kode_witel' => 'R02',
                'no_do' => 'DO-501562',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '4',
            ],
            [
                'sn_lama' => 'SGH516TYSV',
                'tipe_perangkat' => 'PC',
                'sn_pengganti' => '8CG9441HQ7',
                'sn_monitor' => '3CQ93717GQ',
                'id_user' => '3',
                'kode_image' => 'GEN',
                'kode_witel' => 'P55',
                'no_do' => 'DO-501562',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '5',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => 'PC',
                'sn_pengganti' => '8CG9441HMZ',
                'sn_monitor' => '3CQ93717M0',
                'id_user' => '3',
                'kode_image' => 'GEN',
                'kode_witel' => 'P55',
                'no_do' => null,
                'keterangan' => 'tambahan',
                'cek_status' => 'NPS',
                'perolehan' => 'NCD',
                'sp' => '5',
            ],
        ]);
    }
}
