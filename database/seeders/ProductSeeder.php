<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Users
        User::updateOrCreate(
            ['email' => 'admin@neropc.com'],
            [
                'name' => 'Admin NeroPC',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@neropc.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('user123'),
                'role' => 'customer',
            ]
        );

        // 2. Seed Products
        $products = [
            // PROCESSORS
            [
                'sku' => 'CPU-INTEL-I3-13100F',
                'name' => 'Intel Core i3-13100F Processor',
                'category' => 'Processor',
                'brand' => 'Intel',
                'price' => 1250000,
                'stock' => 20,
                'description' => 'Processor desktop generasi ke-13 Intel Core i3-13100F. Tanpa grafis terintegrasi.',
                'specifications' => [
                    'Socket' => 'LGA1700',
                    'Cores' => '4 Cores / 8 Threads',
                    'Speed' => '3.4 GHz (Base) - 4.5 GHz (Boost)',
                    'Power (TDP)' => '60W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'CPU-INTEL-I5-13400F',
                'name' => 'Intel Core i5-13400F Processor',
                'category' => 'Processor',
                'brand' => 'Intel',
                'price' => 2850000,
                'stock' => 15,
                'description' => 'Processor desktop generasi ke-13 Intel Core i5-13400F dengan hybrid architecture.',
                'specifications' => [
                    'Socket' => 'LGA1700',
                    'Cores' => '10 Cores (6 P-cores + 4 E-cores)',
                    'Speed' => '2.5 GHz (Base) - 4.6 GHz (Boost)',
                    'Power (TDP)' => '65W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'CPU-AMD-R5-7600X',
                'name' => 'AMD Ryzen 5 7600X Processor',
                'category' => 'Processor',
                'brand' => 'AMD',
                'price' => 3450000,
                'stock' => 12,
                'description' => 'Processor kencang AMD Ryzen 5 berbasis arsitektur Zen 4 untuk socket AM5.',
                'specifications' => [
                    'Socket' => 'AM5',
                    'Cores' => '6 Cores / 12 Threads',
                    'Speed' => '4.7 GHz (Base) - 5.3 GHz (Boost)',
                    'Power (TDP)' => '105W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // MOTHERBOARDS
            [
                'sku' => 'MB-ASUS-H610M-K',
                'name' => 'ASUS Prime H610M-K D4 Motherboard',
                'category' => 'Motherboard',
                'brand' => 'ASUS',
                'price' => 1100000,
                'stock' => 10,
                'description' => 'Motherboard entry level socket LGA1700 untuk processor Intel Gen 12/13/14.',
                'specifications' => [
                    'Socket' => 'LGA1700',
                    'Chipset' => 'Intel H610',
                    'Memory Support' => '2x DDR4 DIMM (Up to 64GB)',
                    'Form Factor' => 'Micro-ATX',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'MB-ASUS-B760M-A',
                'name' => 'ASUS Prime B760M-A WIFI DDR5',
                'category' => 'Motherboard',
                'brand' => 'ASUS',
                'price' => 2450000,
                'stock' => 8,
                'description' => 'Motherboard mid-range Intel dengan dukungan DDR5 dan WiFi terintegrasi.',
                'specifications' => [
                    'Socket' => 'LGA1700',
                    'Chipset' => 'Intel B760',
                    'Memory Support' => '4x DDR5 DIMM (Up to 192GB)',
                    'Form Factor' => 'Micro-ATX',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'MB-MSI-B650M-A',
                'name' => 'MSI PRO B650M-A WIFI DDR5',
                'category' => 'Motherboard',
                'brand' => 'MSI',
                'price' => 2600000,
                'stock' => 8,
                'description' => 'Motherboard AM5 tangguh untuk mendampingi AMD Ryzen generasi terbaru.',
                'specifications' => [
                    'Socket' => 'AM5',
                    'Chipset' => 'AMD B650',
                    'Memory Support' => '4x DDR5 DIMM (Up to 192GB)',
                    'Form Factor' => 'Micro-ATX',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // RAM
            [
                'sku' => 'RAM-KINGSTON-8GB-DDR4',
                'name' => 'Kingston ValueRAM 8GB DDR4 3200MHz',
                'category' => 'RAM',
                'brand' => 'Kingston',
                'price' => 350000,
                'stock' => 30,
                'description' => 'Memori RAM DDR4 8GB single channel hemat daya dan stabil.',
                'specifications' => [
                    'Capacity' => '8GB (1x8GB)',
                    'Type' => 'DDR4',
                    'Speed' => '3200 MHz',
                    'Voltage' => '1.2V',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'RAM-CORSAIR-16GB-DDR5',
                'name' => 'Corsair Vengeance DDR5 16GB (2x8GB) 5200MHz',
                'category' => 'RAM',
                'brand' => 'Corsair',
                'price' => 1150000,
                'stock' => 25,
                'description' => 'Kit memori DDR5 berperforma tinggi dengan profil XMP 3.0.',
                'specifications' => [
                    'Capacity' => '16GB (2x8GB)',
                    'Type' => 'DDR5',
                    'Speed' => '5200 MHz',
                    'Voltage' => '1.25V',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'RAM-GSKILL-32GB-DDR5',
                'name' => 'G.Skill Ripjaws S5 32GB (2x16GB) 6000MHz DDR5',
                'category' => 'RAM',
                'brand' => 'G.Skill',
                'price' => 2100000,
                'stock' => 15,
                'description' => 'RAM DDR5 premium berkapasitas besar dan berkecepatan ekstrim.',
                'specifications' => [
                    'Capacity' => '32GB (2x16GB)',
                    'Type' => 'DDR5',
                    'Speed' => '6000 MHz',
                    'Voltage' => '1.35V',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // VGA / GRAPHICS CARD
            [
                'sku' => 'VGA-ASUS-GTX1650-4G',
                'name' => 'ASUS Phoenix GTX 1650 4GB GDDR6',
                'category' => 'VGA',
                'brand' => 'ASUS',
                'price' => 2150000,
                'stock' => 10,
                'description' => 'Kartu grafis gaming entry level yang kompak dan efisien.',
                'specifications' => [
                    'VRAM' => '4GB GDDR6',
                    'Interface' => 'PCI Express 3.0',
                    'Power Connection' => 'None (Slot powered)',
                    'Suggested PSU' => '300W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'VGA-MSI-RTX4060-8G',
                'name' => 'MSI RTX 4060 Ventus 2X Black 8G OC',
                'category' => 'VGA',
                'brand' => 'MSI',
                'price' => 4950000,
                'stock' => 8,
                'description' => 'GPU NVIDIA arsitektur Ada Lovelace dengan DLSS 3 dan Ray Tracing.',
                'specifications' => [
                    'VRAM' => '8GB GDDR6',
                    'Interface' => 'PCI Express 4.0',
                    'Power Connection' => '1x 8-pin',
                    'Suggested PSU' => '500W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'VGA-ASUS-RTX4070-12G',
                'name' => 'ASUS Dual RTX 4070 Super 12GB GDDR6X',
                'category' => 'VGA',
                'brand' => 'ASUS',
                'price' => 11450000,
                'stock' => 6,
                'description' => 'Performa grafis luar biasa untuk gaming 1440p maksimal.',
                'specifications' => [
                    'VRAM' => '12GB GDDR6X',
                    'Interface' => 'PCI Express 4.0',
                    'Power Connection' => '1x 16-pin (12VHPWR)',
                    'Suggested PSU' => '650W',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // STORAGE
            [
                'sku' => 'SSD-KINGTON-NV2-500G',
                'name' => 'Kingston NV2 NVMe SSD 500GB',
                'category' => 'Storage',
                'brand' => 'Kingston',
                'price' => 590000,
                'stock' => 20,
                'description' => 'Solusi penyimpanan internal berkecepatan tinggi PCIe Gen 4x4 NVMe.',
                'specifications' => [
                    'Capacity' => '500GB',
                    'Form Factor' => 'M.2 2280',
                    'Read Speed' => 'Up to 3,500 MB/s',
                    'Write Speed' => 'Up to 2,100 MB/s',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'SSD-SAMSUNG-980PRO-1T',
                'name' => 'Samsung 980 Pro PCIe 4.0 NVMe 1TB',
                'category' => 'Storage',
                'brand' => 'Samsung',
                'price' => 1550000,
                'stock' => 12,
                'description' => 'SSD NVMe premium dengan read speed ekstrim untuk gaming dan content creation.',
                'specifications' => [
                    'Capacity' => '1TB',
                    'Form Factor' => 'M.2 2280',
                    'Read Speed' => 'Up to 7,000 MB/s',
                    'Write Speed' => 'Up to 5,000 MB/s',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // PSU
            [
                'sku' => 'PSU-DEEPCOOL-PF500',
                'name' => 'Deepcool PF500 500W 80 Plus',
                'category' => 'PSU',
                'brand' => 'Deepcool',
                'price' => 580000,
                'stock' => 15,
                'description' => 'Power supply handal 500 Watt bersertifikasi standar 80 Plus.',
                'specifications' => [
                    'Wattage' => '500W',
                    'Efficiency' => '80 Plus Standard',
                    'Modular' => 'Non-Modular',
                    'Warranty' => '3 Years',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'PSU-CORSAIR-RM650E',
                'name' => 'Corsair RM650e 650W 80+ Gold Fully Modular',
                'category' => 'PSU',
                'brand' => 'Corsair',
                'price' => 1480000,
                'stock' => 10,
                'description' => 'PSU fully modular dengan efisiensi tinggi 80+ Gold dan low noise.',
                'specifications' => [
                    'Wattage' => '650W',
                    'Efficiency' => '80 Plus Gold',
                    'Modular' => 'Fully Modular',
                    'Warranty' => '7 Years',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // CASING
            [
                'sku' => 'CASE-PARADOX-TRIDENT',
                'name' => 'Paradox Gaming Trident Micro ATX Case',
                'category' => 'Casing',
                'brand' => 'Paradox',
                'price' => 450000,
                'stock' => 12,
                'description' => 'Casing Micro-ATX dengan panel depan mesh untuk sirkulasi udara maksimal.',
                'specifications' => [
                    'Type' => 'Micro-ATX Tower',
                    'Side Panel' => 'Tempered Glass',
                    'Color' => 'Black',
                    'Included Fan' => '3x 120mm RGB Fan',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],
            [
                'sku' => 'CASE-NZXT-H5FLOW-B',
                'name' => 'NZXT H5 Flow Mid Tower Case Black',
                'category' => 'Casing',
                'brand' => 'NZXT',
                'price' => 1390000,
                'stock' => 8,
                'description' => 'Casing premium dengan airflow istimewa dan manajemen kabel yang rapi.',
                'specifications' => [
                    'Type' => 'Mid Tower',
                    'Side Panel' => 'Tempered Glass',
                    'Color' => 'Matte Black',
                    'Included Fan' => '2x 120mm Fan',
                ],
                'image_path' => null,
                'is_recommended' => false,
            ],

            // PREBUILT PC BUNDLES (Recommended)
            [
                'sku' => 'PC-NEROPC-STARTER-GAMING',
                'name' => 'NeroPC Starter Gaming Package',
                'category' => 'Prebuilt PC',
                'brand' => 'NeroPC Custom',
                'price' => 6499000,
                'stock' => 5,
                'description' => 'Paket PC rakitan siap pakai. Cocok untuk produktivitas harian, belajar online, dan gaming kasual seperti Valorant & GTA V.',
                'specifications' => [
                    'Processor' => 'Intel Core i3-13100F',
                    'Motherboard' => 'ASUS H610M-K',
                    'RAM' => 'Kingston 8GB DDR4 3200MHz',
                    'VGA' => 'ASUS Phoenix GTX 1650 4GB',
                    'Storage' => 'Kingston NV2 NVMe 500GB',
                    'PSU' => 'Deepcool PF500 500W',
                    'Casing' => 'Paradox Gaming Trident',
                ],
                'image_path' => null,
                'is_recommended' => true,
            ],
            [
                'sku' => 'PC-NEROPC-MID-RTX4060',
                'name' => 'NeroPC Mid-Range RTX 4060 Gaming PC',
                'category' => 'Prebuilt PC',
                'brand' => 'NeroPC Custom',
                'price' => 13499000,
                'stock' => 4,
                'description' => 'Rakitan gaming level menengah ke atas. Kuat melibas game AAA modern dengan setting tinggi berkat DLSS 3 dan prosesor i5 generasi terbaru.',
                'specifications' => [
                    'Processor' => 'Intel Core i5-13400F',
                    'Motherboard' => 'ASUS Prime B760M-A WIFI',
                    'RAM' => 'Corsair Vengeance 16GB DDR5 5200MHz',
                    'VGA' => 'MSI RTX 4060 Ventus 2X 8G',
                    'Storage' => 'Kingston NV2 NVMe 500GB',
                    'PSU' => 'Corsair RM650e 650W Gold',
                    'Casing' => 'NZXT H5 Flow Black',
                ],
                'image_path' => null,
                'is_recommended' => true,
            ],
            [
                'sku' => 'PC-NEROPC-ULTIMATE-ZEN4',
                'name' => 'NeroPC Ultimate Ryzen 5 & RTX 4070',
                'category' => 'Prebuilt PC',
                'brand' => 'NeroPC Custom',
                'price' => 22499000,
                'stock' => 3,
                'description' => 'Monster gaming platform AM5 generasi terbaru. Didesain untuk gaming resolusi 2K/4K ultra dan rendering video profesional.',
                'specifications' => [
                    'Processor' => 'AMD Ryzen 5 7600X',
                    'Motherboard' => 'MSI PRO B650M-A WIFI',
                    'RAM' => 'G.Skill Ripjaws S5 32GB DDR5 6000MHz',
                    'VGA' => 'ASUS Dual RTX 4070 Super 12GB',
                    'Storage' => 'Samsung 980 Pro 1TB NVMe',
                    'PSU' => 'Corsair RM650e 650W Gold',
                    'Casing' => 'NZXT H5 Flow Black',
                ],
                'image_path' => null,
                'is_recommended' => true,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['sku' => $prod['sku']],
                $prod
            );
        }
    }
}
