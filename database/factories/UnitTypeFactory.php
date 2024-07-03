<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = UnitType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $unitTypes = \Satis2020\ServicePackage\Models\UnitType::all();

        $parent_id = $unitTypes->count() > 0 && $this->faker->randomElement([true, false])
            ? $unitTypes->random()->id
            : null;

        return [
            'id' => (string)Str::uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'parent_id' => $parent_id
        ];
    }
}
