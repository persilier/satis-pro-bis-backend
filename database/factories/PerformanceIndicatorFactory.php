<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformanceIndicatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = PerformanceIndicator::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'value' => $this->faker->numberBetween(1, 100),
            'mesure_unit' => '%' 
        ];
    }
}
