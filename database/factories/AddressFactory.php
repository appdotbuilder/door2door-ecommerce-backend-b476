<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $labels = ['Home', 'Office', 'Apartment', 'Parents House'];
        $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi'];
        $provinces = ['DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Sumatera Utara', 'Sumatera Selatan', 'Sulawesi Selatan'];
        
        return [
            'user_id' => User::factory(),
            'label' => fake()->randomElement($labels),
            'recipient_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($cities),
            'province' => fake()->randomElement($provinces),
            'postal_code' => fake()->postcode(),
            'notes' => fake()->optional()->sentence(),
            'is_default' => false,
        ];
    }
}