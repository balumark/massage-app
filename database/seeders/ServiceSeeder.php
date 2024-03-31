<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert(
            [
                [
                    'title' => 'Massage 1',
                    'price' => 2000,
                ],
                [
                    'title' => 'Massage 2',
                    'price' => 4000,
                ],
                [
                    'title' => 'Massage 3',
                    'price' => 6000,
                ],
            ]
        );
    }
}
