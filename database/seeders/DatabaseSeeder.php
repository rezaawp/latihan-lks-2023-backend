<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name'          => 'rezawp',
            'email'         => 'rezawp@gmail.com',
            'password'      => bcrypt('12341234'),
            'role'          => 'user'
        ]);

        User::create([
            'name'          => 'admin',
            'email'         => 'admin@gmail.com',
            'password'      => bcrypt('12341234'),
            'role'          => 'admin'
        ]);
    }
}
