<?php

namespace Database\Seeders;

use App\Jobs\RoleBoot;
use App\Jobs\SettingBoot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
         \App\Models\User::factory(3)->create();

//         \App\Models\User::factory()->create([
//             'name' => 'Elliot',
//             'email' => 'elliot@gmail.com',
//             'password' => '',
//         ]);
    }
}
