<?php

use Illuminate\Database\Seeder;

class PriceQuantityHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PriceQuantityHistory::class, 30)->create();

    }
}
