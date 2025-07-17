<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinsi = Provinsi::orderBy('created_at', 'desc')->get();
        return view('provinsi.index', compact('provinsi'));
    }
    public function laporan()
    {
        $laporanProvinsi = Provinsi::withCount('penduduk')
            ->orderBy('nama_provinsi', 'asc')
            ->get();

        return view('provinsi.laporan', compact('laporanProvinsi'));
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
        $request->validate([
            'nama_provinsi' => 'required|string|max:255|unique:provinsi,nama_provinsi'
        ], [
            'nama_provinsi.required' => 'Nama provinsi wajib diisi',
            'nama_provinsi.unique' => 'Nama provinsi sudah ada'
        ]);

        try {
            Provinsi::create([
                'nama_provinsi' => $request->nama_provinsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan provinsi'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Provinsi $provinsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provinsi $provinsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'nama_provinsi' => 'required|string|max:255|unique:provinsi,nama_provinsi,' . $provinsi->id
        ], [
            'nama_provinsi.required' => 'Nama provinsi wajib diisi',
            'nama_provinsi.unique' => 'Nama provinsi sudah ada'
        ]);

        try {
            $provinsi->update([
                'nama_provinsi' => $request->nama_provinsi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate provinsi'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provinsi $provinsi)
    {
        try {
            $provinsi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Provinsi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus provinsi'
            ], 500);
        }
    }
}
