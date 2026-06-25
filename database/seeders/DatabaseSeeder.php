<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $client = User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => bcrypt('password'),
            'role' => 'client',
        ]);

        // Categories & Products Data
        $data = [
            'Électronique' => [
                'description' => 'Derniers gadgets et appareils technologiques.',
                'products' => [
                    ['name' => 'MacBook Pro M3', 'price' => 19999.0, 'description' => 'Le plus puissant des laptops Apple.'],
                    ['name' => 'iPhone 15 Pro', 'price' => 12499.0, 'description' => 'Performances incroyables et design en titane.'],
                    ['name' => 'Sony WH-1000XM5', 'price' => 3499.0, 'description' => 'Réduction de bruit leader du marché.'],
                ]
            ],
            'Mode' => [
                'description' => 'Vêtements et accessoires tendance.',
                'products' => [
                    ['name' => 'Veste en Cuir Premium', 'price' => 1500.0, 'description' => 'Style intemporel et cuir de qualité.'],
                    ['name' => 'Sneakers Air Max', 'price' => 1200.0, 'description' => 'Confort et style pour le quotidien.'],
                ]
            ],
            'Maison' => [
                'description' => 'Tout pour un intérieur confortable.',
                'products' => [
                    ['name' => 'Machine à Café Espresso', 'price' => 2500.0, 'description' => 'Le meilleur café chez vous.'],
                    ['name' => 'Lampe de Bureau LED', 'price' => 450.0, 'description' => 'Éclairage ajustable pour travailler.'],
                ]
            ]
        ];

        foreach ($data as $catName => $catData) {
            $category = Category::create([
                'name' => $catName,
                'description' => $catData['description'],
                'image' => 'https://picsum.photos/400/400?random=' . rand(1, 100)
            ]);

            foreach ($catData['products'] as $prod) {
                $product = Product::create([
                    'name' => $prod['name'],
                    'slug' => Str::slug($prod['name']),
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'stock' => rand(10, 50),
                    'category_id' => $category->id
                ]);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'https://picsum.photos/600/800?random=' . rand(1, 10000)
                ]);

                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $client->id,
                    'rating' => 5,
                    'comment' => 'Produit exceptionnel !'
                ]);
            }
        }

        // Simulating one order
        $order = Order::create([
            'user_id' => $client->id,
            'total_price' => 19999.0,
            'status' => 'completed',
            'address' => '123 Rue Hassan II',
            'city' => 'Rabat',
            'phone' => '0612345678'
        ]);

        $p = Product::where('name', 'MacBook Pro M3')->first();
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p->id,
            'quantity' => 1,
            'price' => $p->price
        ]);
    }
}
