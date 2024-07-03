<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdentiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Identite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sexe = $this->faker->randomElement(['male', 'female']);

        return [
            'id' => (string) Str::uuid(),
            'firstname' => $this->faker->firstName($sexe),
            'lastname' => $this->faker->lastName,
            'sexe' => strtoupper(substr($sexe, 0, 1)),
            'telephone' => [$this->faker->phoneNumber],
            'email' => [$this->faker->safeEmail]
        ];
    }
}
