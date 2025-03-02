<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'item_id' => Item::factory(), 
            'payment_method' => $this->faker->randomElement(['card', 'konbini']),
            'shipping_address' => $this->faker->address,
            'shipping_post_code' => $this->faker->postcode,
            'shipping_building' => $this->faker->secondaryAddress,
        ];
    }
}
