<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Guru;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas1 = Kelas::create([
            'nama_kelas' => 'XI RPL 1'
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'XI RPL 2'
        ]);

        $kelas3 = Kelas::create([
            'nama_kelas' => 'XI DKV 1'
        ]);

        $kelas1->siswas()->createMany([
            ['nama' => 'Hanif', 'orang_tua_id' => '1'],
            ['nama' => 'Cahyo', 'orang_tua_id' => '2'],
        ]);

        $kelas2->siswas()->createMany([
            ['nama' => 'Prasetyo', 'orang_tua_id' => '3'],
            ['nama' => 'Hafidz', 'orang_tua_id' => '4'],
        ]);

        $kelas3->siswas()->createMany([
            ['nama' => 'Arum', 'orang_tua_id' => '5'],
        ]);

        $kelas1->gurus()->createMany([
            ['nama' => 'Rudi'],
        ]);

        $kelas2->gurus()->createMany([
            ['nama' => 'Yuni'],
        ]);

        $kelas3->gurus()->createMany([
            ['nama' => 'Rere'],
        ]);
    }
}
