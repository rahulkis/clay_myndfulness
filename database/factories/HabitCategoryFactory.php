<?php

namespace Database\Factories;

use App\Models\HabitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabitCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HabitCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"  => $this->faker->word
        ];
    }
}
