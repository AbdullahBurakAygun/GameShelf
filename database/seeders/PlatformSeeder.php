<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        dump('🖥 PlatformSeeder ÇALIŞTI');

        $platforms = [
            'PC',
            'PlayStation 5',
            'Xbox Series X',
            'Nintendo Switch',
            'Mobile',
        ];

        foreach ($platforms as $name) {
            Platform::firstOrCreate(['name' => $name]);
        }
    }
}
