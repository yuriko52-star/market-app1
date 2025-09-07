<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'img_url' => $this->faker->imageUrl(),
            'post_code' => $this->faker->postcode,
            'address' => $this->faker->address,
            'building' => $this->faker->secondaryAddress,
        ];
    }
}
