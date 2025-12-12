<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;


namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        $tagNames = Tag::pluck('id')->toArray();

        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(10, 80),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'bio' => $this->faker->sentence(10),
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people', true, 'Profile'),
            'favourite_genres' => implode(', ', $this->faker->randomElements(
                $tagNames,
                rand(1, min(3, count($tagNames)))
            )),
        ];
    }
}

