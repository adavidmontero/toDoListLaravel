<?php

namespace Database\Seeders;

use App\Models\CheckList;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Andrés Montero',
            'email' => 'correo@correo.com',
            'password' => bcrypt('12345678')
        ]);

        /* CheckList::factory(2)->create(); */
    }
}
