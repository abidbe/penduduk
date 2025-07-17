<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kabupaten = Kabupaten::with('provinsi')->orderBy('created_at', 'desc')->get();
        $provinsi = Provinsi::orderBy('nama_provinsi', 'asc')->get();
        return view('kabupaten.index', compact('kabupaten', 'provinsi'));
    }

    public function laporan(Request $request)
    {
        $query = Kabupaten::with('provinsi')->withCount('penduduk');

        // Filter berdasarkan provinsi jika ada
        if ($request->has('provinsi_id') && $request->provinsi_id != '') {
            $query->where('provinsi_id', $request->provinsi_id);
        }

        $laporanKabupaten = $query->orderBy('nama_kabupaten', 'asc')->get();
        $provinsi = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        return view('kabupaten.laporan', compact('laporanKabupaten', 'provinsi'));
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
            'nama_kabupaten' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id'
        ], [
            'nama_kabupaten.required' => 'Nama kabupaten wajib diisi',
            'provinsi_id.required' => 'Provinsi wajib dipilih',
            'provinsi_id.exists' => 'Provinsi tidak valid'
        ]);

        try {
            Kabupaten::create([
                'nama_kabupaten' => $request->nama_kabupaten,
                'provinsi_id' => $request->provinsi_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kabupaten berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kabupaten'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kabupaten $kabupaten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kabupaten $kabupaten)
    {
        $request->validate([
            'nama_kabupaten' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id'
        ], [
            'nama_kabupaten.required' => 'Nama kabupaten wajib diisi',
            'provinsi_id.required' => 'Provinsi wajib dipilih',
            'provinsi_id.exists' => 'Provinsi tidak valid'
        ]);

        try {
            $kabupaten->update([
                'nama_kabupaten' => $request->nama_kabupaten,
                'provinsi_id' => $request->provinsi_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kabupaten berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kabupaten'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kabupaten $kabupaten)
    {
        try {
            $kabupaten->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kabupaten berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kabupaten'
            ], 500);
        }
    }
}
