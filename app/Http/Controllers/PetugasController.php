<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // Method untuk cek role
    private function checkRole()
    {
        if (!in_array(auth()->user()->role, ['admin', 'petugas'])) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function dashboard()
    {
        $this->checkRole();
        return view('petugas.dashboard');
    }

    public function barangMasuk()
    {
        $this->checkRole();
        return view('petugas.barang-masuk');
    }

    public function simpanBarangMasuk(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date'
        ]);

        BarangMasuk::create($request->all());

        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        return redirect()->back()->with('success', 'Barang masuk berhasil dicatat');
    }

    public function barangKeluar()
    {
        $this->checkRole();
        return view('petugas.barang-keluar');
    }

    public function simpanBarangKeluar(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date'
        ]);

        $barang = Barang::find($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup. Stok tersedia: ' . $barang->stok]);
        }

        BarangKeluar::create($request->all());

        $barang->stok -= $request->jumlah;
        $barang->save();

        return redirect()->back()->with('success', 'Barang keluar berhasil dicatat');
    }

    public function daftarBarang()
    {
        $this->checkRole();

        $barangs = Barang::with('kategori', 'lokasi')->get();
        return view('petugas.daftar-barang', compact('barangs'));
    }

    public function detailBarang($id)
    {
        $this->checkRole();

        $barang = Barang::with('kategori', 'lokasi')->findOrFail($id);
        return view('petugas.detail-barang', compact('barang'));
    }
}