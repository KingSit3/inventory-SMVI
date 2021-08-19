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
                'nama' => 'Bambang',
                'nik' => '6701852',
                'no_telp' => '081018603633',
            ],
            [
                'nama' => 'Widodo',
                'nik' => null,
                'no_telp' => '62819583790',
            ],
            [
                'nama' => 'HERU',
                'nik' => '8028420',
                'no_telp' => '08110183125',
            ],
            [
                'nama' => 'EKO',
                'nik' => '6318019618',
                'no_telp' => null,
            ],
        ]);
    }
}
