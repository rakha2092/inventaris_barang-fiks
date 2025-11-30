<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Elektronik',
                'deskripsi' => 'Barang-barang elektronik dan peralatan listrik',
            ],
            [
                'nama' => 'Alat Tulis Kantor',
                'deskripsi' => 'Peralatan tulis menulis dan kebutuhan kantor',
            ],
            [
                'nama' => 'Furniture',
                'deskripsi' => 'Perabotan dan mebel kantor',
            ],
            [
                'nama' => 'Perlengkapan Kebersihan',
                'deskripsi' => 'Alat dan bahan kebersihan',
            ],
            [
                'nama' => 'IT Equipment',
                'deskripsi' => 'Peralatan teknologi informasi dan komputer',
            ],
            [
                'nama' => 'Kendaraan',
                'deskripsi' => 'Kendaraan operasional perusahaan',
            ],
            [
                'nama' => 'Bahan Habis Pakai',
                'deskripsi' => 'Bahan yang habis dipakai dalam operasional',
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $this->command->info('Kategoris seeded successfully!');
    }
}