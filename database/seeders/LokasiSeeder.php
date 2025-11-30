<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = [
            [
                'nama' => 'Gudang Utama',
                'deskripsi' => 'Gudang penyimpanan utama',
            ],
            [
                'nama' => 'Gudang Bahan Baku',
                'deskripsi' => 'Gudang untuk bahan baku produksi',
            ],
            [
                'nama' => 'Ruang Admin',
                'deskripsi' => 'Ruang kerja administrasi',
            ],
            [
                'nama' => 'Ruang Produksi',
                'deskripsi' => 'Area produksi dan manufacturing',
            ],
            [
                'nama' => 'Ruang Meeting',
                'deskripsi' => 'Ruang rapat dan pertemuan',
            ],
            [
                'nama' => 'Laboratorium',
                'deskripsi' => 'Ruang lab dan penelitian',
            ],
            [
                'nama' => 'Parkiran Kendaraan',
                'deskripsi' => 'Area parkir kendaraan operasional',
            ],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::create($lokasi);
        }

        $this->command->info('Lokasis seeded successfully!');
    }
}