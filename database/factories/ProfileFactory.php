<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(10, 80),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'bio' => $this->faker->sentence(10),
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people', true, 'Profile'),
            'favourite_genres' => implode(', ', $this->faker->randomElements(
                ['Pop', 'Rock', 'Hip Hop', 'Jazz', 'Classical', 'Electronic'], 
                rand(1, 3)
            )),
        ];
    }
}
