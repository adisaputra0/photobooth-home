<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\PhotoboothTemplate;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        PhotoboothTemplate::create([
            "name" => "Template 1",
            "file_path" => "templates/slot-1.png",
            "slots" => 1,
        ]);
        PhotoboothTemplate::create([
            "name" => "Template 2",
            "file_path" => "templates/slot-4.png",
            "slots" => 4,
        ]);
        PhotoboothTemplate::create([
            "name" => "Template 3",
            "file_path" => "templates/slot-6.png",
            "slots" => 6,
        ]);
    }
}
