<?php

namespace Database\Factories;

use App\Models\Don;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'don_id' => Don::factory(),
            'from_user_id' => User::factory(),
            'to_user_id' => User::factory(),
            'contenu' => $this->faker->sentence(10),
        ];
    }
}
