<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stores;
use App\Models\Categories;
use App\Models\Items;
use App\Models\StockMovements;
use App\Models\ActivityLogs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Clickbar\Magellan\Data\Geometries\Point;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Owner User
        $user = User::firstOrCreate(
            ['email' => 'owner@pantau.com'],
            [
                'name' => 'Store Owner',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'is_super_admin' => false,
            ]
        );

        // 2. Create Store with Location
        // Jakarta coordinates: -6.2088, 106.8456
        $store = Stores::create([
            'name' => 'Pantau Official Store',
            'slug' => 'pantau-official',
            'contact_info' => '0812-3456-7890',
            'address' => 'Jl. Jend. Sudirman No. Kav 1, Jakarta Pusat',
            'description' => 'Official store providing high quality spare parts and accessories.',
            'location' => Point::make(106.8456, -6.2088), // Longitude, Latitude
            'status' => 'approved', // Important: Must be approved to be visible
        ]);

        // 3. Link User to Store
        $user->update(['store_id' => $store->id]);

        $this->command->info('🏪 Store created: ' . $store->name);

        // 4. Create Categories
        $categories = ['Spareparts', 'Accessories', 'Oil & Fluids', 'Tires', 'Helmets'];
        $categoryModels = [];

        foreach ($categories as $catName) {
            $categoryModels[$catName] = Categories::create([
                'name' => $catName,
                'store_id' => $store->id,
            ]);
        }

        // 5. Create Items
        // 5. Create Items
        $items = [
            [
                'name' => 'Yamalube Sport Oil 1L',
                'code' => 'OIL-001',
                'description' => 'High performance engine oil for sport motorcycles.',
                'category' => 'Oil & Fluids',
                'price' => 85000,
                'quantity' => 50,
                // 'image' => 'products/oil.jpg', // Placeholder
            ],
            [
                'name' => 'Michelin Pilot Street 120/70-17',
                'code' => 'TIRE-001',
                'description' => 'Tubeless tire with excellent grip on wet and dry roads.',
                'category' => 'Tires',
                'price' => 450000,
                'quantity' => 10,
                // 'image' => 'products/tire.jpg',
            ],
            [
                'name' => 'KYT NF-R Helmet',
                'code' => 'HLM-001',
                'description' => 'Full face helmet with double visor and aerodynamic design.',
                'category' => 'Helmets',
                'price' => 2200000,
                'quantity' => 5,
                // 'image' => 'products/helmet.jpg',
            ],
            [
                'name' => 'NGK Iridium Spark Plug',
                'code' => 'SPK-001',
                'description' => 'High ignitability and longer service life.',
                'category' => 'Spareparts',
                'price' => 120000,
                'quantity' => 100,
                // 'image' => 'products/sparkplug.jpg',
            ],
            [
                'name' => 'Phone Holder Aluminum',
                'code' => 'ACC-001',
                'description' => 'Sturdy aluminum phone holder for handlebars.',
                'category' => 'Accessories',
                'price' => 75000,
                'quantity' => 25,
                // 'image' => 'products/holder.jpg',
            ],
        ];

        foreach ($items as $itemData) {
            $item = Items::create([
                'name' => $itemData['name'],
                'code' => $itemData['code'],
                'description' => $itemData['description'],
                'category_id' => $categoryModels[$itemData['category']]->id,
                'price' => $itemData['price'],
                'quantity' => $itemData['quantity'],
                'store_id' => $store->id,
                // 'image' => $itemData['image'],
            ]);

            // Initial Stock Movement
            StockMovements::create([
                'store_id' => $store->id,
                'item_id' => $item->id,
                'quantity_change' => $itemData['quantity'],
                'type' => 'in',
                'notes' => 'Initial stock seeding',
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('📦 Added ' . count($items) . ' items to the store.');
        $this->command->info('✅ Store seeding completed!');
        $this->command->info('📧 Login: owner@pantau.com / password');
    }
}
