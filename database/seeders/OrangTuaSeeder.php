<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrangTua;

class OrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orangtua1 = OrangTua::create([
            'nama' => 'Budi'
        ]);

        $orangtua2 = orangtua::create([
            'nama' => 'Arif'
        ]);

        $orangtua3 = orangtua::create([
            'nama' => 'Sulis'
        ]);

        $orangtua4 = orangtua::create([
            'nama' => 'Andra'
        ]);

        $orangtua5 = orangtua::create([
            'nama' => 'Rudi'
        ]);
    }
}
