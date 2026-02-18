<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh guru.
     *
     * Mengambil semua data guru dari database dan mengirimkannya
     * ke view 'guru.index' untuk ditampilkan dalam bentuk tabel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $gurus = Guru::with('kelas')->get();
        $kelas = Kelas::all();
        return view('guru.index', compact('gurus', 'kelas'));
    }

    /**
     * Menyimpan guru baru ke database.
     *
     * Menerima request AJAX dari form modal tambah di view.
     * Melakukan validasi input, membuat record baru, lalu
     * mengembalikan data guru yang dibuat sebagai JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama string required Nama guru baru. Contoh: Hanif Prasetyo
     * @bodyParam kelas_id integer required ID kelas guru. Contoh: 1
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $guru = Guru::create($data);

        $guru->load('kelas'); // Memuat relasi kelas untuk mendapatkan nama_kelas

        return response()->json([
            'success' => true,
            'guru' => $guru,   // Dikirim ke JS untuk membuat baris baru di tabel
            'message' => 'Guru berhasil ditambahkan',
        ]);
    }

    /**
     * Memperbarui data guru yang sudah ada di database.
     *
     * Menerima request AJAX dari form modal edit di view (via method spoofing PUT).
     * Mencari guru berdasarkan id, memvalidasi input, lalu memperbarui record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  ID guru yang akan diperbarui
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama string required Nama Guru yang baru. Contoh: Hanif Cahyo Prasetyo
     * @bodyParam kelas_id integer required ID kelas guru. Contoh: 2
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update($data);

        $guru->load('kelas'); // Memuat relasi kelas untuk mendapatkan nama_kelas

        return response()->json([
            'success' => true,
            'guru' => $guru,   // Dikirim ke JS untuk memperbarui baris di tabel
            'message' => 'Guru berhasil diupdate',
        ]);
    }

    /**
     * Menghapus guru dari database.
     *
     * Menerima request AJAX DELETE dari modal konfirmasi hapus di view.
     * Mencari guru berdasarkan id, lalu menghapus record tersebut.
     *
     * @param  string  $id  ID guru yang akan dihapus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil dihapus',
        ]);
    }
}
