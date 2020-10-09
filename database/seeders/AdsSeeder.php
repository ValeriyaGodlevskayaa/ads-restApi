<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO `ads`  (`name`, `description`, `price`) VALUES (?,?,?) ',
            [
                'Ad One',
                '<p>Test description for this ad one.</p>',
                33.3
            ]);
    }
}
