<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CreditApplication;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.com',
        ]);

        // Create test customers
        $customers = User::factory(20)->create();

        // Create categories
        $categories = [
            ['name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'description' => 'Berbagai camilan dan makanan ringan'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Minuman segar dan sehat'],
            ['name' => 'Produk Susu', 'slug' => 'produk-susu', 'description' => 'Susu dan produk olahannya'],
            ['name' => 'Bumbu Dapur', 'slug' => 'bumbu-dapur', 'description' => 'Bumbu dan rempah untuk memasak'],
            ['name' => 'Bahan Pokok', 'slug' => 'bahan-pokok', 'description' => 'Beras, minyak, gula dan kebutuhan pokok'],
            ['name' => 'Perawatan Pribadi', 'slug' => 'perawatan-pribadi', 'description' => 'Sabun, shampo dan produk perawatan'],
            ['name' => 'Pembersih Rumah', 'slug' => 'pembersih-rumah', 'description' => 'Detergen dan pembersih rumah tangga'],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            
            // Create 5-10 products per category
            Product::factory(random_int(5, 10))->create([
                'category_id' => $category->id
            ]);
        }

        // Create addresses for customers
        foreach ($customers as $customer) {
            Address::factory(random_int(1, 3))->create([
                'user_id' => $customer->id
            ]);
            
            // Set first address as default
            $customer->addresses()->first()->update(['is_default' => true]);
        }

        // Create orders with items
        $products = Product::all();
        foreach ($customers->take(15) as $customer) {
            $orderCount = random_int(1, 5);
            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::factory()->create([
                    'user_id' => $customer->id,
                    'delivery_address' => $customer->addresses()->first()->toArray()
                ]);

                // Create 1-5 order items
                $itemCount = random_int(1, 5);
                $orderSubtotal = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = random_int(1, 3);
                    $price = $product->price;
                    $total = $quantity * $price;
                    $orderSubtotal += $total;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $total,
                    ]);
                }

                // Update order totals
                $order->update([
                    'subtotal' => $orderSubtotal,
                    'total' => $orderSubtotal + $order->delivery_fee
                ]);
            }
        }

        // Create credit applications
        foreach ($customers->take(10) as $customer) {
            CreditApplication::factory()->create([
                'user_id' => $customer->id
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@ecommerce.com');
        $this->command->info('Created: ' . User::count() . ' users, ' . Category::count() . ' categories, ' . Product::count() . ' products');
    }
}
