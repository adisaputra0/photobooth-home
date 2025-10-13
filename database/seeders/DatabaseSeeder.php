<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\HargaPaket;
use App\Models\HargaPerOrang;
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
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('adminnyarahde'),
        ]);
        HargaPaket::create([
            'nama_paket' => "basic",
            "harga" => 90000,
        ]);
        HargaPaket::create([
            'nama_paket' => "spotlight",
            "harga" => 130000,
        ]);
        // HargaPaket::create([
        //     'nama_paket' => "projector",
        //     "harga" => 140000,
        // ]);
        HargaPaket::create([
            'nama_paket' => "photobox",
            "harga" => 30000,
        ]);
        HargaPerorang::create([
            "harga" => 35000,
        ]);
        
        PhotoboothTemplate::create([
            "name" => "Template 1",
            "file_path" => "templates/slot-2.png",
            "slots" => 2,
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
