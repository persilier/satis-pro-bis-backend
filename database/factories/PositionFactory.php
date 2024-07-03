<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Satis2020\ServicePackage\Models\Position;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Position::class;

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
            'description' => $this->faker->text
        ];
    }
}
