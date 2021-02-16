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
        DB::table('do')->insert([
            [
                'no_do' => 'DO-501562',
            ],
            [
                'no_do' => 'DO-501563',
            ],
            [
                'no_do' => 'DO-501564',
            ],
        ]);
    }
}
