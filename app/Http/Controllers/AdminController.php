<?php
namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function cek()
    {
        if (auth()->user()->role !== 'admin')
            abort(403);
    }

    public function dashboard()
    {
        $this->cek();
        $totalBarang = Barang::count();
        $barangHampirHabis = Barang::hampirHabis()->count();
        return view('admin.dashboard', compact('totalBarang', 'barangHampirHabis'));
    }

    // Kategori
    public function kategoriIndex()
    {
        $this->cek();
        $kategoris = Kategori::withCount('barangs')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function kategoriStore(Request $r)
    {
        $this->cek();
        $r->validate(['nama' => 'required|max:255|unique:kategoris,nama', 'deskripsi' => 'nullable|max:500']);
        Kategori::create($r->all());
        return redirect('/admin/kategori')->with('success', 'Kategori ditambahkan');
    }

    public function kategoriEdit($id)
    {
        $this->cek();
        $item = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('item'));
    }

    public function kategoriUpdate(Request $r, $id)
    {
        $this->cek();
        $r->validate(['nama' => 'required|max:255|unique:kategoris,nama,' . $id, 'deskripsi' => 'nullable|max:500']);
        try {
            Kategori::findOrFail($id)->update($r->all());
            return redirect('/admin/kategori')->with('success', 'Kategori diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function kategoriDestroy($id)
    {
        $this->cek();
        try {
            DB::beginTransaction();
            $item = Kategori::findOrFail($id);
            if ($item->barangs()->count() > 0) {
                return redirect('/admin/kategori')->with('error', 'Masih digunakan ' . $item->barangs()->count() . ' barang');
            }
            $item->delete();
            DB::commit();
            return redirect('/admin/kategori')->with('success', 'Kategori dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/kategori')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // Lokasi
    public function lokasiIndex()
    {
        $this->cek();
        $lokasis = Lokasi::withCount('barangs')->get();
        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function lokasiCreate()
    {
        $this->cek();
        return view('admin.lokasi.create');
    }

    public function lokasiStore(Request $r)
    {
        $this->cek();
        $r->validate(['nama' => 'required|max:255|unique:lokasis,nama', 'deskripsi' => 'nullable|max:500']);
        Lokasi::create($r->all());
        return redirect('/admin/lokasi')->with('success', 'Lokasi ditambahkan');
    }

    public function lokasiEdit($id)
    {
        $this->cek();
        $item = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('item'));
    }

    public function lokasiUpdate(Request $r, $id)
    {
        $this->cek();
        $r->validate(['nama' => 'required|max:255|unique:lokasis,nama,' . $id, 'deskripsi' => 'nullable|max:500']);
        try {
            Lokasi::findOrFail($id)->update($r->all());
            return redirect('/admin/lokasi')->with('success', 'Lokasi diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function lokasiDestroy($id)
    {
        $this->cek();
        try {
            DB::beginTransaction();
            $item = Lokasi::findOrFail($id);
            if ($item->barangs()->count() > 0) {
                return redirect('/admin/lokasi')->with('error', 'Masih digunakan ' . $item->barangs()->count() . ' barang');
            }
            $item->delete();
            DB::commit();
            return redirect('/admin/lokasi')->with('success', 'Lokasi dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/lokasi')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // Barang
    public function barangIndex()
    {
        $this->cek();
        $barangs = Barang::with('kategori', 'lokasi')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function barangCreate()
    {
        $this->cek();
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('admin.barang.create', compact('kategoris', 'lokasis'));
    }



    public function barangStore(Request $r)
    {
        $this->cek();
        $r->validate([
            'nama' => 'required|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'stok' => 'required|numeric|min:0',
            'stok_minimum' => 'nullable|numeric|min:1',
            'deskripsi' => 'nullable|max:1000'
        ]);
        $last = Barang::orderBy('id', 'desc')->first();
        $next = $last ? $last->id + 1 : 1;
        $kode = 'BRG' . str_pad($next, 4, '0', STR_PAD_LEFT);
        Barang::create([
            'kode_barang' => $kode,
            'nama' => $r->nama,
            'kategori_id' => $r->kategori_id,
            'lokasi_id' => $r->lokasi_id,
            'stok' => $r->stok,
            'stok_minimum' => $r->stok_minimum ?? 3,
            'deskripsi' => $r->deskripsi
        ]);
        return redirect('/admin/barang')->with('success', 'Barang ditambah');
    }

    public function edit($id)
    {
        $this->cek();
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('admin.barang.edit', compact('barang', 'kategoris', 'lokasis'));
    }

    public function update(Request $r, $id)
    {
        $this->cek();
        $r->validate([
            'nama' => 'required|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'stok' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:1',
            'deskripsi' => 'nullable|max:1000'
        ]);
        try {
            Barang::findOrFail($id)->update($r->all());
            return redirect('/admin/barang')->with('success', 'Barang diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->cek();
        try {
            DB::beginTransaction();
            $item = Barang::findOrFail($id);
            BarangMasuk::where('barang_id', $id)->delete();
            BarangKeluar::where('barang_id', $id)->delete();
            $item->delete();
            DB::commit();
            return redirect('/admin/barang')->with('success', 'Barang dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/barang')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // Lainnya
    public function barangHampirHabis()
    {
        $this->cek();
        $barangs = Barang::hampirHabis()->with('kategori', 'lokasi')->get();
        return view('admin.laporan.hampir-habis', compact('barangs'));
    }

    public function showRestockForm($id)
    {
        $this->cek();
        $item = Barang::findOrFail($id);
        return view('admin.barang.restock', compact('item'));
    }

    public function processRestock(Request $r, $id)
    {
        $this->cek();
        $r->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date'
        ]);
        try {
            DB::beginTransaction();
            $item = Barang::findOrFail($id);
            BarangMasuk::create([
                'barang_id' => $id,
                'jumlah' => $r->jumlah,
                'keterangan' => $r->keterangan,
                'tanggal' => $r->tanggal
            ]);
            $item->increment('stok', $r->jumlah);
            DB::commit();
            return redirect('/admin/laporan/hampir-habis')->with('success', 'Restock berhasil +' . $r->jumlah);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function showBarangDetail($id)
    {
        $this->cek();
        $item = Barang::with('kategori', 'lokasi')->findOrFail($id);
        $masuk = BarangMasuk::where('barang_id', $id)->orderBy('tanggal', 'desc')->limit(10)->get();
        $keluar = BarangKeluar::where('barang_id', $id)->orderBy('tanggal', 'desc')->limit(10)->get();
        return view('admin.barang.detail', compact('item', 'masuk', 'keluar'));
    }

    public function laporanStok()
    {
        $this->cek();
        $barangs = Barang::with('kategori', 'lokasi')->get();
        return view('admin.laporan.stok', compact('barangs'));
    }
}