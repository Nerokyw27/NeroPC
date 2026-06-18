<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pc;

class PcSeeder extends Seeder
{
    public function run(): void
    {
        Pc::insert([
            [
                'user_id' => 1,
                'kode_pc' => 'NPC-001',
                'nama_pc' => 'NeroPC Starter',
                'kategori' => 'ENTRY LEVEL',
                'prosesor' => 'Intel Core i3-13100',
                'vga' => 'NVIDIA GTX 1650 4GB',
                'ram' => '8GB DDR4',
                'storage' => '256GB SSD',
                'motherboard' => 'ASUS H610M-K',
                'psu' => 'Be Quiet 500W 80+',
                'casing' => 'Infinity Casing ATX',
                'harga' => 5100000,
                'stok' => 12,
                'tersedia' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'kode_pc' => 'NPC-002',
                'nama_pc' => 'NeroPC Gaming',
                'kategori' => 'MID RANGE',
                'prosesor' => 'Intel Core i5-13400F',
                'vga' => 'NVIDIA RTX 3060 12GB',
                'ram' => '16GB DDR4',
                'storage' => '512GB NVMe SSD',
                'motherboard' => 'MSI B660M Mortar',
                'psu' => 'Seasonic Focus 650W 80+ Gold',
                'casing' => 'NZXT H5 Flow',
                'harga' => 8500000,
                'stok' => 7,
                'tersedia' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'kode_pc' => 'NPC-003',
                'nama_pc' => 'NeroPC Pro Gaming',
                'kategori' => 'MID RANGE',
                'prosesor' => 'AMD Ryzen 5 7600X',
                'vga' => 'AMD RX 7600 8GB',
                'ram' => '16GB DDR5',
                'storage' => '1TB NVMe SSD',
                'motherboard' => 'ASUS B650M-A',
                'psu' => 'Corsair RM650 80+ Gold',
                'casing' => 'Corsair 4000D Airflow',
                'harga' => 9200000,
                'stok' => 4,
                'tersedia' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
