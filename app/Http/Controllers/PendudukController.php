<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penduduk = Penduduk::with(['kabupaten.provinsi'])->orderBy('created_at', 'desc')->get();
        $provinsi = Provinsi::orderBy('nama_provinsi', 'asc')->get();
        $kabupaten = Kabupaten::with('provinsi')->orderBy('nama_kabupaten', 'asc')->get();
        return view('penduduk.index', compact('penduduk', 'provinsi', 'kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk',
            'nama' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'umur' => 'required|integer|min:0|max:150',
            'alamat' => 'required|string'
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'kabupaten_id.required' => 'Kabupaten wajib dipilih',
            'kabupaten_id.exists' => 'Kabupaten tidak valid',
            'umur.required' => 'Umur wajib diisi',
            'umur.integer' => 'Umur harus berupa angka',
            'umur.min' => 'Umur minimal 0',
            'umur.max' => 'Umur maksimal 150',
            'alamat.required' => 'Alamat wajib diisi'
        ]);

        try {
            Penduduk::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'kabupaten_id' => $request->kabupaten_id,
                'umur' => $request->umur,
                'alamat' => $request->alamat
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penduduk berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan penduduk'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk,nik,' . $penduduk->id,
            'nama' => 'required|string|max:255',
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'umur' => 'required|integer|min:0|max:150',
            'alamat' => 'required|string'
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama.required' => 'Nama wajib diisi',
            'kabupaten_id.required' => 'Kabupaten wajib dipilih',
            'kabupaten_id.exists' => 'Kabupaten tidak valid',
            'umur.required' => 'Umur wajib diisi',
            'umur.integer' => 'Umur harus berupa angka',
            'umur.min' => 'Umur minimal 0',
            'umur.max' => 'Umur maksimal 150',
            'alamat.required' => 'Alamat wajib diisi'
        ]);

        try {
            $penduduk->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'kabupaten_id' => $request->kabupaten_id,
                'umur' => $request->umur,
                'alamat' => $request->alamat
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Penduduk berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate penduduk'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        try {
            $penduduk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Penduduk berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus penduduk'
            ], 500);
        }
    }

    /**
     * Get kabupaten by provinsi
     */
    public function getKabupatenByProvinsi($provinsiId)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsiId)
            ->orderBy('nama_kabupaten', 'asc')
            ->get();

        return response()->json($kabupaten);
    }
}
