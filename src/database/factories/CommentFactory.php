<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentFactory extends Factory
{   protected $model = Comment::class;
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
            'comment' => $this->faker->sentence,
        ];
    }
}
