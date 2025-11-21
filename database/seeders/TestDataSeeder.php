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

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        $user = User::create([
            'name' => 'Test Owner',
            'email' => 'owner@test.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'is_super_admin' => false,
        ]);

        // Create test store
        $store = Stores::create([
            'name' => 'Test Store',
            'slug' => 'test-store',
            'contact_info' => '08123456789',
            'address' => 'Jl. Test Raya No. 123, Jakarta',
            'description' => 'Test store for inventory management',
        ]);

        // Update user with store_id
        $user->update(['store_id' => $store->id]);

        // Create categories
        $categories = [
            'Electronics' => 'Electronic devices and accessories',
            'Furniture' => 'Office and home furniture',
            'Office Supplies' => 'Stationery and office equipment',
            'Clothing' => 'Apparel and accessories',
            'Books' => 'Books and reading materials',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $desc) {
            $categoryModels[$name] = Categories::create([
                'name' => $name,
                'store_id' => $store->id,
            ]);

            ActivityLogs::create([
                'store_id' => $store->id,
                'user_id' => $user->id,
                'action' => 'category_created',
                'description' => "Created category: {$name}",
            ]);
        }

        // Create items
        $items = [
            [
                'name' => 'Laptop Dell XPS 13',
                'code' => 'LAPTOP001',
                'description' => 'High-performance laptop with Intel i7 processor',
                'category' => 'Electronics',
                'price' => 15000000,
                'quantity' => 15,
            ],
            [
                'name' => 'Office Chair Ergonomic',
                'code' => 'CHAIR001',
                'description' => 'Comfortable ergonomic office chair',
                'category' => 'Furniture',
                'price' => 1500000,
                'quantity' => 8,
            ],
            [
                'name' => 'Printer HP LaserJet',
                'code' => 'PRINTER001',
                'description' => 'Laser printer with duplex printing',
                'category' => 'Electronics',
                'price' => 3000000,
                'quantity' => 5,
            ],
            [
                'name' => 'Wooden Desk',
                'code' => 'DESK001',
                'description' => 'Solid wood office desk',
                'category' => 'Furniture',
                'price' => 2500000,
                'quantity' => 12,
            ],
            [
                'name' => 'Stapler Heavy Duty',
                'code' => 'STAPLER001',
                'description' => 'Heavy duty office stapler',
                'category' => 'Office Supplies',
                'price' => 50000,
                'quantity' => 50,
            ],
            [
                'name' => 'Paper A4 500 Sheets',
                'code' => 'PAPER001',
                'description' => 'White A4 paper, 80gsm',
                'category' => 'Office Supplies',
                'price' => 40000,
                'quantity' => 100,
            ],
            [
                'name' => 'Men\'s Formal Shirt',
                'code' => 'SHIRT001',
                'description' => 'Cotton formal shirt, various sizes',
                'category' => 'Clothing',
                'price' => 250000,
                'quantity' => 25,
            ],
            [
                'name' => 'Novel - Best Seller',
                'code' => 'BOOK001',
                'description' => 'Latest best selling novel',
                'category' => 'Books',
                'price' => 85000,
                'quantity' => 30,
            ],
            [
                'name' => 'Wireless Mouse Logitech',
                'code' => 'MOUSE001',
                'description' => 'Wireless optical mouse',
                'category' => 'Electronics',
                'price' => 150000,
                'quantity' => 20,
            ],
            [
                'name' => 'Whiteboard Marker Set',
                'code' => 'MARKER001',
                'description' => 'Set of 4 whiteboard markers',
                'category' => 'Office Supplies',
                'price' => 15000,
                'quantity' => 60,
            ],
            [
                'name' => 'USB Flash Drive 32GB',
                'code' => 'USB001',
                'description' => '32GB USB 3.0 flash drive',
                'category' => 'Electronics',
                'price' => 100000,
                'quantity' => 3, // Low stock item
            ],
            [
                'name' => 'Desk Lamp LED',
                'code' => 'LAMP001',
                'description' => 'Adjustable LED desk lamp',
                'category' => 'Furniture',
                'price' => 200000,
                'quantity' => 7, // Low stock item
            ],
        ];

        $itemModels = [];
        foreach ($items as $itemData) {
            $item = Items::create([
                'name' => $itemData['name'],
                'code' => $itemData['code'],
                'description' => $itemData['description'],
                'category_id' => $categoryModels[$itemData['category']]->id,
                'price' => $itemData['price'],
                'quantity' => $itemData['quantity'],
                'store_id' => $store->id,
            ]);

            $itemModels[] = $item;

            ActivityLogs::create([
                'store_id' => $store->id,
                'user_id' => $user->id,
                'action' => 'item_created',
                'description' => "Created item: {$item->name} (Code: {$item->code})",
            ]);

            // Create initial stock movement for each item
            if ($itemData['quantity'] > 0) {
                StockMovements::create([
                    'store_id' => $store->id,
                    'item_id' => $item->id,
                    'quantity_change' => $itemData['quantity'],
                    'type' => 'in',
                    'notes' => 'Initial stock',
                    'user_id' => $user->id,
                ]);
            }
        }

        // Create some additional stock movements
        $movements = [
            [
                'item' => $itemModels[0], // Laptop
                'quantity' => 10,
                'type' => 'in',
                'notes' => 'Restocking from Supplier ABC - Invoice #INV-2025-001',
            ],
            [
                'item' => $itemModels[1], // Office Chair
                'quantity' => 3,
                'type' => 'out',
                'notes' => 'Sold to PT. XYZ Company - Order #ORD-2025-045',
            ],
            [
                'item' => $itemModels[5], // Paper A4
                'quantity' => 50,
                'type' => 'in',
                'notes' => 'Bulk purchase for office use',
            ],
            [
                'item' => $itemModels[7], // Novel
                'quantity' => 15,
                'type' => 'out',
                'notes' => 'Book fair sales event',
            ],
            [
                'item' => $itemModels[8], // Wireless Mouse
                'quantity' => 30,
                'type' => 'in',
                'notes' => 'New stock arrival from distributor',
            ],
            [
                'item' => $itemModels[2], // Printer
                'quantity' => 2,
                'type' => 'out',
                'notes' => 'Customer purchase - Retail sale',
            ],
        ];

        foreach ($movements as $movement) {
            StockMovements::create([
                'store_id' => $store->id,
                'item_id' => $movement['item']->id,
                'quantity_change' => $movement['quantity'],
                'type' => $movement['type'],
                'notes' => $movement['notes'],
                'user_id' => $user->id,
            ]);

            // Update item quantity
            if ($movement['type'] === 'in') {
                $movement['item']->increment('quantity', $movement['quantity']);
            } else {
                $movement['item']->decrement('quantity', $movement['quantity']);
            }

            // Log activity
            $typeLabel = $movement['type'] === 'in' ? 'Stock In' : 'Stock Out';
            ActivityLogs::create([
                'store_id' => $store->id,
                'user_id' => $user->id,
                'action' => 'stock_movement_' . $movement['type'],
                'description' => "{$typeLabel}: {$movement['item']->name} ({$movement['quantity']} units) - {$movement['notes']}",
            ]);
        }

        $this->command->info('✅ Test data created successfully!');
        $this->command->info('');
        $this->command->info('📧 Email: owner@test.com');
        $this->command->info('🔑 Password: password');
        $this->command->info('🏪 Store: Test Store');
        $this->command->info('📦 Items: ' . count($itemModels) . ' items created');
        $this->command->info('🏷️  Categories: ' . count($categoryModels) . ' categories created');
        $this->command->info('📊 Stock Movements: ' . (count($movements) + count($itemModels)) . ' movements created');
    }
}
