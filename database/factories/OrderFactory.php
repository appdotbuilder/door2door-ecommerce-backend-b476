<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(0, 50000, 500000);
        $deliveryFee = 15000;
        $total = $subtotal + $deliveryFee;
        
        return [
            'order_number' => Order::generateOrderNumber(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'accepted', 'processing', 'shipped', 'delivered']),
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'payment_method' => fake()->randomElement(['cod', 'bank_transfer', 'qris']),
            'payment_status' => fake()->randomElement(['pending', 'paid']),
            'payment_reference' => fake()->optional()->uuid(),
            'delivery_address' => [
                'recipient_name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->streetAddress(),
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => fake()->postcode(),
            ],
            'delivery_date' => fake()->dateTimeBetween('now', '+1 week'),
            'delivery_time' => fake()->randomElement(['09:00-12:00', '13:00-16:00', '17:00-20:00']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}