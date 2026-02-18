<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh siswa.
     *
     * Mengambil semua data siswa dari database dan mengirimkannya
     * ke view 'siswa.index' untuk ditampilkan dalam bentuk tabel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('siswa.index', compact('siswas', 'kelas'));
    }

    /**
     * Menyimpan siswa baru ke database.
     *
     * Menerima request AJAX dari form modal tambah di view.
     * Melakukan validasi input, membuat record baru, lalu
     * mengembalikan data siswa yang dibuat sebagai JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama string required Nama siswa baru. Contoh: Hanif Prasetyo
     * @bodyParam kelas_id integer required ID kelas siswa. Contoh: 1
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::create($data);

        $siswa->load('kelas'); // Memuat relasi kelas untuk mendapatkan nama_kelas

        return response()->json([
            'success' => true,
            'siswa' => $siswa,   // Dikirim ke JS untuk membuat baris baru di tabel
            'message' => 'Siswa berhasil ditambahkan',
        ]);
    }

    /**
     * Memperbarui data siswa yang sudah ada di database.
     *
     * Menerima request AJAX dari form modal edit di view (via method spoofing PUT).
     * Mencari siswa berdasarkan id, memvalidasi input, lalu memperbarui record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  ID siswa yang akan diperbarui
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama string required Nama Siswa yang baru. Contoh: Hanif Cahyo Prasetyo
     * @bodyParam kelas_id integer required ID kelas siswa. Contoh: 2
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($data);

        $siswa->load('kelas'); // Memuat relasi kelas untuk mendapatkan nama_kelas

        return response()->json([
            'success' => true,
            'siswa' => $siswa,   // Dikirim ke JS untuk memperbarui baris di tabel
            'message' => 'Siswa berhasil diupdate',
        ]);
    }

    /**
     * Menghapus siswa dari database.
     *
     * Menerima request AJAX DELETE dari modal konfirmasi hapus di view.
     * Mencari siswa berdasarkan id, lalu menghapus record tersebut.
     *
     * @param  string  $id  ID siswa yang akan dihapus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dihapus',
        ]);
    }
}
