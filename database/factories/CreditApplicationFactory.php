<?php

namespace Database\Factories;

use App\Models\CreditApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditApplication>
 */
class CreditApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $requestedAmount = fake()->randomFloat(0, 500000, 5000000);
        $status = fake()->randomElement(['pending', 'approved', 'rejected']);
        
        $data = [
            'user_id' => User::factory(),
            'requested_amount' => $requestedAmount,
            'status' => $status,
            'notes' => fake()->optional()->sentence(),
        ];
        
        if ($status === 'approved') {
            $approvedLimit = $requestedAmount * fake()->randomFloat(2, 0.5, 1.2);
            $usedLimit = fake()->randomFloat(0, 0, $approvedLimit * 0.8);
            
            $data['approved_limit'] = $approvedLimit;
            $data['used_limit'] = $usedLimit;
            $data['available_limit'] = $approvedLimit - $usedLimit;
            $data['reviewed_at'] = fake()->dateTimeBetween('-1 month', 'now');
        } elseif ($status === 'rejected') {
            $data['reviewed_at'] = fake()->dateTimeBetween('-1 month', 'now');
        }
        
        return $data;
    }
}