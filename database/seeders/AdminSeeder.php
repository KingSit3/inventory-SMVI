<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            [
                'name' => 'indra',
                'email' => 'indra@gmail.com',
                'role' => '0',
                'status' => '1',
                'password' => '$2y$10$x.aLTiOe9fmBSx2gqNfWxu8CBJHaWsARu0URFhsfwJHfF4kq4fQAW',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => '1',
                'status' => '1',
                'password' => '$2y$10$OBzbwtGyFACXzJqoh.aZOOEmZjfrslWJtD.E81NIEgrgUD3uyQtyi',
            ],
            [
                'name' => 'staff',
                'email' => 'staff@gmail.com',
                'role' => '2',
                'status' => '1',
                'password' => '$2y$10$tQuKe/NQLMTJvZ10f3hs7e9ARNVd0.48SSyRWgKZ1padtpCYFZUdm',
            ],
        ]);
    }
}
