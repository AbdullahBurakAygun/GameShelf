<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        dump('DatabaseSeeder run() ');

        $this->call([
            GenreSeeder::class,
            PlatformSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => bcrypt('password'),
                'role'     => 'admin',
            ]
        );

        User::factory(5)->create();
    }
}
