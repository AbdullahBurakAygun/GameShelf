<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        dump('🎮 GenreSeeder ÇALIŞTI');

        $genres = [
            'Action',
            'Adventure',
            'RPG',
            'FPS',
            'Strategy',
            'Sports',
            'Puzzle',
        ];

        foreach ($genres as $name) {
            Genre::firstOrCreate(['name' => $name]);
        }
    }
}
