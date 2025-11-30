<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    // Method untuk cek role
    private function checkRole()
    {
        if (!in_array(auth()->user()->role, ['admin', 'pimpinan'])) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function dashboard()
    {
        $this->checkRole();
        return view('pimpinan.dashboard');
    }

    public function laporanStok()
    {
        $this->checkRole();

        $barangs = Barang::with('kategori', 'lokasi')->get();
        return view('pimpinan.laporan-stok', compact('barangs'));
    }

    public function laporanTransaksi()
    {
        $this->checkRole();

        $barangMasuk = BarangMasuk::with('barang')->orderBy('tanggal', 'desc')->get();
        $barangKeluar = BarangKeluar::with('barang')->orderBy('tanggal', 'desc')->get();

        return view('pimpinan.laporan-transaksi', compact('barangMasuk', 'barangKeluar'));
    }

    public function barangHampirHabis()
    {
        $this->checkRole();

        $barangRendah = Barang::hampirHabis()->with('kategori', 'lokasi')->get();
        return view('pimpinan.barang-hampir-habis', compact('barangRendah'));
    }
}