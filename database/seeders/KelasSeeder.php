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
            ['nama' => 'Hanif'],
            ['nama' => 'Cahyo'],
        ]);

        $kelas2->siswas()->createMany([
            ['nama' => 'Prasetyo'],
            ['nama' => 'Hafidz'],
        ]);

        $kelas3->siswas()->createMany([
            ['nama' => 'Arum'],
            ['nama' => 'Maulia'],
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
