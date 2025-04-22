<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Apple iPhone 15 Pro',
                'description' => 'The ultimate iPhone with a titanium design, A17 Pro chip, and an advanced camera system. Featuring a 6.1-inch Super Retina XDR display with ProMotion and Always-On technology.',
                'price' => 999.99,
                'stock' => 50,
                'image' => 'iphone15pro.jpg',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Experience the power of Galaxy AI with the S24 Ultra, featuring a 200MP camera system, Snapdragon 8 Gen 3 processor, and S Pen functionality. Designed with premium materials for durability.',
                'price' => 1199.99,
                'stock' => 40,
                'image' => 'galaxys24ultra.jpg',
            ],
            [
                'name' => 'Apple MacBook Pro 16"',
                'description' => 'Supercharged by M3 Pro or M3 Max, the MacBook Pro features exceptional performance, up to 22 hours of battery life, and a stunning Liquid Retina XDR display.',
                'price' => 2499.99,
                'stock' => 25,
                'image' => 'macbookpro16.jpg',
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise cancelation with eight microphones and Auto NC Optimizer. Crystal clear hands-free calling and 30-hour battery life with quick charging.',
                'price' => 399.99,
                'stock' => 100,
                'image' => 'sonywh1000xm5.jpg',
            ],
            [
                'name' => 'Apple iPad Pro 12.9"',
                'description' => 'Featuring the Apple M2 chip, stunning Liquid Retina XDR display, ultra-fast 5G connectivity, and Apple Pencil hover capability for professional-level creativity.',
                'price' => 1099.99,
                'stock' => 45,
                'image' => 'ipadpro129.jpg',
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'description' => 'Samsung\'s largest and most powerful tablet with a 14.6" Dynamic AMOLED 2x display, Snapdragon 8 Gen 2 processor, and an included S Pen for creative work.',
                'price' => 1199.99,
                'stock' => 30,
                'image' => 'galaxytabs9ultra.jpg',
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'The most advanced Pixel phone with a 50MP main camera, the new Tensor G3 processor, and seven years of OS and security updates guaranteed.',
                'price' => 899.99,
                'stock' => 60,
                'image' => 'pixel8pro.jpg',
            ],
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Featuring the powerful S9 SiP, a brighter Always-On Retina display, and new double-tap gesture for easier one-handed use.',
                'price' => 399.99,
                'stock' => 75,
                'image' => 'applewatch9.jpg',
            ],
            [
                'name' => 'Microsoft Surface Laptop Studio',
                'description' => 'A powerful workstation with a unique flexible display that transforms from laptop to stage to studio mode, powered by Intel Core H Series processors and NVIDIA RTX graphics.',
                'price' => 1599.99,
                'stock' => 20,
                'image' => 'surfacelaptopstudio.jpg',
            ],
            [
                'name' => 'Samsung Galaxy Buds 3 Pro',
                'description' => 'Premium earbuds with intelligent ANC, Hi-Fi sound quality, and seamless device switching for Galaxy ecosystem users.',
                'price' => 229.99,
                'stock' => 120,
                'image' => 'galaxybuds3pro.jpg',
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}