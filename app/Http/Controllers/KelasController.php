<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

/**
 * KelasController
 *
 * Controller untuk mengelola data Kelas (CRUD).
 * Seluruh operasi create, update, dan delete merespons dengan JSON
 * karena digunakan bersama AJAX dari view kelas/index.blade.php.
 *
 * Routes yang dilayani (resource):
 *   GET    /kelas          → index()   : Tampilkan halaman daftar kelas
 *   POST   /kelas          → store()   : Simpan kelas baru
 *   POST   /kelas/{id}     → update()  : Update kelas (via method spoofing _method=PUT)
 *   DELETE /kelas/{id}     → destroy() : Hapus kelas
 */
class KelasController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh kelas.
     *
     * Mengambil semua data kelas dari database dan mengirimkannya
     * ke view 'kelas.index' untuk ditampilkan dalam bentuk tabel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    /**
     * Menyimpan kelas baru ke database.
     *
     * Menerima request AJAX dari form modal tambah di view.
     * Melakukan validasi input, membuat record baru, lalu
     * mengembalikan data kelas yang dibuat sebagai JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama_kelas string required Nama kelas baru. Contoh: XII RPL 1
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::create($data);

        return response()->json([
            'success' => true,
            'kelas' => $kelas,   // Dikirim ke JS untuk membuat baris baru di tabel
            'message' => 'Kelas berhasil ditambahkan',
        ]);
    }

    /**
     * Memperbarui data kelas yang sudah ada di database.
     *
     * Menerima request AJAX dari form modal edit di view (via method spoofing PUT).
     * Mencari kelas berdasarkan id, memvalidasi input, lalu memperbarui record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  ID kelas yang akan diperbarui
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam nama_kelas string required Nama kelas yang baru. Contoh: XII RPL 2
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate',
        ]);
    }

    /**
     * Menghapus kelas dari database.
     *
     * Menerima request AJAX DELETE dari modal konfirmasi hapus di view.
     * Mencari kelas berdasarkan id, lalu menghapus record tersebut.
     *
     * @param  string  $id  ID kelas yang akan dihapus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus',
        ]);
    }
}
