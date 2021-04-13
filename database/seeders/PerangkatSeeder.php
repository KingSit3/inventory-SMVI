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
                'tipe_perangkat' => '1',
                'sn_pengganti' => 'FVFZJ3YFL410',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => '1',
                'kode_witel' => '1',
                'no_do' => '1',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '3',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => '2',
                'sn_pengganti' => 'FVFZJ475L410',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => '3',
                'kode_witel' => '2',
                'no_do' => '2',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '1',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => '3',
                'sn_pengganti' => 'FVFYR2SHJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => '1',
                'kode_witel' => '2',
                'no_do' => null,
                'keterangan' => 'Tambahan',
                'cek_status' => 'NCS',
                'perolehan' => 'NCD',
                'sp' => '2',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => '1',
                'sn_pengganti' => 'FVFYR2RHJ1WT',
                'sn_monitor' => null,
                'id_user' => '1',
                'kode_image' => '2',
                'kode_witel' => '1',
                'no_do' => '3',
                'keterangan' => 'Tambahan',
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '1',
            ],
            [
                'sn_lama' => 'SGH516TYSV',
                'tipe_perangkat' => '2',
                'sn_pengganti' => '8CG9441HQ7',
                'sn_monitor' => '3CQ93717GQ',
                'id_user' => '3',
                'kode_image' => '2',
                'kode_witel' => '3',
                'no_do' => '2',
                'keterangan' => null,
                'cek_status' => 'OBC',
                'perolehan' => 'NCD',
                'sp' => '2',
            ],
            [
                'sn_lama' => null,
                'tipe_perangkat' => '3',
                'sn_pengganti' => '8CG9441HMZ',
                'sn_monitor' => '3CQ93717M0',
                'id_user' => '3',
                'kode_image' => '1',
                'kode_witel' => '1',
                'no_do' => null,
                'keterangan' => 'tambahan',
                'cek_status' => 'NPS',
                'perolehan' => 'NCD',
                'sp' => '1',
            ],
        ]);
    }
}
