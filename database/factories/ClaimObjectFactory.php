<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaimObjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

     protected $model = ClaimObject::class;

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
            'claim_category_id' => \Satis2020\ServicePackage\Models\ClaimCategory::all()->random()->id,
            'severity_levels_id' => \Satis2020\ServicePackage\Models\SeverityLevel::all()->random()->id,
            'time_limit' => $this->faker->numberBetween(1, 7)
        ];
    }
}
