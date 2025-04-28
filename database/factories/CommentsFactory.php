<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'news_id' => News::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'comment_text' => $this->faker->realText(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }

    public function negativeRating()
    {
        return $this->state(fn (array $attributes) => ['rating' => $this->faker->numberBetween(-5, -1)]);
    }

}
