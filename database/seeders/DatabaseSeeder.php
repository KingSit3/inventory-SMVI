<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ImageSeeder::class,
            PerangkatSeeder::class,
            TipePerangkat::class,
            WitelSeeder::class,
            DoSeeder::class,
        ]);
    }
}
