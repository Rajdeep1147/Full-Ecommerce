<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $name = $this->faker->unique()->word; // Unique name
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name), // Slugify the name
            'status' => $this->faker->randomElement(['1', '0']),
        ];
    }
}
