<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Don>
 */
class DonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorie = $this->faker->randomElement(['nourriture', 'vêtements', 'meubles', 'électronique']);
        
        return [
            'titre' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'categorie' => $this->faker->randomElement(['nourriture', 'vêtements', 'meubles', 'électronique']),
            'localisation' => $this->faker->city(),
            'image' => match ($categorie) 
            {
                'nourriture' => 'https://source.unsplash.com/400x300/?food',
                'vêtements' => 'https://source.unsplash.com/400x300/?clothes',
                'meubles' => 'https://source.unsplash.com/400x300/?furniture',
                'électronique' => 'https://source.unsplash.com/400x300/?electronics',
            },
            'statut' => $this->faker->randomElement(['disponible', 'réservé', 'donné']),
            'user_id' => User::factory(), // crée un donateur automatiquement
        ];
    }
}
