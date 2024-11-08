<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            return Siswa::all();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data siswa.'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'nama' => 'required|regex:/^[a-zA-Z\s]+$/',
            'kelas' => 'required|regex:/^XII IPA \d$/',
            'umur' => 'required|integer|between:6,18',
        ], [
            'nama.required' => 'Nama siswa harus diisi.',
            'nama.regex' => 'Nama siswa hanya boleh berisi huruf dan spasi.',
            'kelas.required' => 'Kelas harus diisi.',
            'kelas.regex' => 'Format kelas harus seperti "XII IPA 1".',
            'umur.required' => 'Umur siswa harus diisi.',
            'umur.integer' => 'Umur siswa harus berupa angka.',
            'umur.between' => 'Umur siswa harus antara 6 hingga 18 tahun.',
        ]);
        
        

        try {
            $siswa = Siswa::create($validatedData);
            return response()->json($siswa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data siswa.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Siswa::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Siswa tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $validatedData = $request->validate([
                'nama' => 'sometimes|required|string|max:255',
                'kelas' => 'sometimes|required|string|max:10',
                'umur' => 'sometimes|required|integer',
            ]);

            $siswa->update($validatedData);
            return response()->json($siswa);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui data siswa.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data siswa.'], 500);
        }
    }
}
