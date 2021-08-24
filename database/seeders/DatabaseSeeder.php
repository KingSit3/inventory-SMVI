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
            CabangSeeder::class,
            PerangkatSeeder::class,
            TipePerangkatSeeder::class,
            TipeSistemSeeder::class,
            PengirimanSeeder::class,
            PenggunaSeeder::class,
            GelombangSeeder::class,
        ]);
    }
}
