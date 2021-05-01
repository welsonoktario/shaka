<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert(
            [
                [
                    'nama' => 'Scaling',
                    'deskripsi' => 'Deskripsi scaling',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'nama' => 'Behel',
                    'deskripsi' => 'Deskripsi behel',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'nama' => 'Perawatan',
                    'deskripsi' => 'Deskripsi',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );

        User::find(2)->service()->attach([1, 2, 3]);
    }
}