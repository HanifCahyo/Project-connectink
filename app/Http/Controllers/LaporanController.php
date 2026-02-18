<?php

namespace App\Http\Controllers;
use App\Models\Kelas;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Poin 5 Mengambil data siswa setiap kelas dan menampilkannya di view
    // Dari model Kelas, get yang berelasi dengan siswa, lalu kirim ke view
    public function siswaPerKelas()
    {
        $data = Kelas::with('siswas')->get();
        return view('laporan.siswa', compact('data'));
    }

    // Poin 6 Mengambil data guru setiap kelas dan menampilkannya di view
    // Dari model Kelas, get yang berelasi dengan guru, lalu kirim ke view
    public function guruPerKelas()
    {
        $data = Kelas::with('gurus')->get();
        return view('laporan.guru', compact('data'));
    }

    // Poin 7 Mengambil data siswa dan guru setiap kelas, lalu menampilkannya di view
    // Dari model Kelas, get yang berelasi dengan siswa dan guru, lalu kirim ke view
    public function semua()
    {
        $data = Kelas::with(['siswas', 'gurus'])->get();
        return view('laporan.semua', compact('data'));
    }
}
