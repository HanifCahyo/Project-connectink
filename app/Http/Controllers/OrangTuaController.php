<?php

namespace App\Http\Controllers;
use App\Models\OrangTua;

use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangtua = OrangTua::all();
        return view('orangtua.index', compact('orangtua'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $orangtua = OrangTua::create($data);

        return response()->json([
            'success' => true,
            'orangtua' => $orangtua,   // Dikirim ke JS untuk membuat baris baru di tabel
            'message' => 'Kelas berhasil ditambahkan',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $orangtua = OrangTua::findOrFail($id);
        $orangtua->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate',
        ]);
    }

    public function destroy(string $id)
    {
        $orangtua = OrangTua::findOrFail($id);
        $orangtua->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus',
        ]);
    }
}
