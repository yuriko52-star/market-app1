<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'img_url' =>$this->faker->randomElement([
                '/storage/images/test.jpg',
                '/storage/images/testC.jpg',
                '/storage/images/testD.jpg',
            ]),
            'user_id' =>User::factory(),
            'condition_id'=>Condition::factory(),
            'brand_name' =>$this->faker->optional()->word,
            'price' => $this->faker->numberBetween(0,10000),
            'description' => $this->faker->text(255),
        ];
    }
}
