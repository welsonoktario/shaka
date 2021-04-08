<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['nama' => 'Admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Dokter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['nama' => 'Pasien', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        User::find(2)->service()->attach([1, 2, 3]);
    }
}
