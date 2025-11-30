<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Get kategori IDs
        $elektronik = Kategori::where('nama', 'Elektronik')->first()->id;
        $atk = Kategori::where('nama', 'Alat Tulis Kantor')->first()->id;
        $furniture = Kategori::where('nama', 'Furniture')->first()->id;
        $kebersihan = Kategori::where('nama', 'Perlengkapan Kebersihan')->first()->id;
        $it = Kategori::where('nama', 'IT Equipment')->first()->id;
        $bahan = Kategori::where('nama', 'Bahan Habis Pakai')->first()->id;

        // Get lokasi IDs
        $gudangUtama = Lokasi::where('nama', 'Gudang Utama')->first()->id;
        $gudangBahan = Lokasi::where('nama', 'Gudang Bahan Baku')->first()->id;
        $ruangAdmin = Lokasi::where('nama', 'Ruang Admin')->first()->id;
        $ruangProduksi = Lokasi::where('nama', 'Ruang Produksi')->first()->id;

        $barangs = [
            // Elektronik
            [
                'kode_barang' => 'ELEC-001',
                'nama' => 'Laptop Dell Latitude',
                'deskripsi' => 'Laptop untuk staff administrasi',
                'kategori_id' => $elektronik,
                'lokasi_id' => $ruangAdmin,
                'stok' => 5,
                'stok_minimum' => 2,
            ],
            [
                'kode_barang' => 'ELEC-002',
                'nama' => 'Printer HP LaserJet',
                'deskripsi' => 'Printer laser untuk cetak dokumen',
                'kategori_id' => $elektronik,
                'lokasi_id' => $ruangAdmin,
                'stok' => 3,
                'stok_minimum' => 1,
            ],
            [
                'kode_barang' => 'ELEC-003',
                'nama' => 'AC Split 2 PK',
                'deskripsi' => 'AC untuk ruang meeting',
                'kategori_id' => $elektronik,
                'lokasi_id' => $gudangUtama,
                'stok' => 2,
                'stok_minimum' => 1,
            ],

            // ATK
            [
                'kode_barang' => 'ATK-001',
                'nama' => 'Kertas A4 70gr',
                'deskripsi' => 'Kertas fotocopy ukuran A4',
                'kategori_id' => $atk,
                'lokasi_id' => $gudangUtama,
                'stok' => 50,
                'stok_minimum' => 10,
            ],
            [
                'kode_barang' => 'ATK-002',
                'nama' => 'Pulpen Standard',
                'deskripsi' => 'Pulpen warna biru',
                'kategori_id' => $atk,
                'lokasi_id' => $gudangUtama,
                'stok' => 100,
                'stok_minimum' => 20,
            ],
            [
                'kode_barang' => 'ATK-003',
                'nama' => 'Stapler Max',
                'deskripsi' => 'Stapler besar',
                'kategori_id' => $atk,
                'lokasi_id' => $gudangUtama,
                'stok' => 8,
                'stok_minimum' => 3,
            ],
            [
                'kode_barang' => 'ATK-004',
                'nama' => 'Map Plastik',
                'deskripsi' => 'Map plastik berbagai warna',
                'kategori_id' => $atk,
                'lokasi_id' => $gudangUtama,
                'stok' => 2, // Stok rendah untuk testing
                'stok_minimum' => 5,
            ],

            // Furniture
            [
                'kode_barang' => 'FURN-001',
                'nama' => 'Meja Kerja',
                'deskripsi' => 'Meja kerja staff',
                'kategori_id' => $furniture,
                'lokasi_id' => $gudangUtama,
                'stok' => 15,
                'stok_minimum' => 5,
            ],
            [
                'kode_barang' => 'FURN-002',
                'nama' => 'Kursi Ergonomis',
                'deskripsi' => 'Kursi kerja yang nyaman',
                'kategori_id' => $furniture,
                'lokasi_id' => $gudangUtama,
                'stok' => 20,
                'stok_minimum' => 5,
            ],

            // Kebersihan
            [
                'kode_barang' => 'CLN-001',
                'nama' => 'Sapu Lantai',
                'deskripsi' => 'Sapu untuk kebersihan lantai',
                'kategori_id' => $kebersihan,
                'lokasi_id' => $gudangUtama,
                'stok' => 10,
                'stok_minimum' => 3,
            ],
            [
                'kode_barang' => 'CLN-002',
                'nama' => 'Kemocil',
                'deskripsi' => 'Tempat sampah kecil',
                'kategori_id' => $kebersihan,
                'lokasi_id' => $gudangUtama,
                'stok' => 1, // Stok rendah untuk testing
                'stok_minimum' => 5,
            ],

            // IT Equipment
            [
                'kode_barang' => 'IT-001',
                'nama' => 'Switch 24 Port',
                'deskripsi' => 'Switch jaringan 24 port',
                'kategori_id' => $it,
                'lokasi_id' => $ruangAdmin,
                'stok' => 3,
                'stok_minimum' => 1,
            ],
            [
                'kode_barang' => 'IT-002',
                'nama' => 'Router Mikrotik',
                'deskripsi' => 'Router untuk jaringan internet',
                'kategori_id' => $it,
                'lokasi_id' => $ruangAdmin,
                'stok' => 2,
                'stok_minimum' => 1,
            ],

            // Bahan Habis Pakai
            [
                'kode_barang' => 'BHP-001',
                'nama' => 'Toner Printer',
                'deskripsi' => 'Toner untuk printer laser',
                'kategori_id' => $bahan,
                'lokasi_id' => $gudangUtama,
                'stok' => 5,
                'stok_minimum' => 3,
            ],
            [
                'kode_barang' => 'BHP-002',
                'nama' => 'Kabel LAN',
                'deskripsi' => 'Kabel LAN CAT6 panjang 3m',
                'kategori_id' => $bahan,
                'lokasi_id' => $gudangUtama,
                'stok' => 0, // Stok habis untuk testing
                'stok_minimum' => 10,
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }

        $this->command->info('Barangs seeded successfully!');
        $this->command->info('Beberapa barang dibuat dengan stok rendah untuk testing fitur "Barang Hampir Habis"');
    }
}