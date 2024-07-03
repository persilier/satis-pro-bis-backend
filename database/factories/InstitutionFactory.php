<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Satis2020\ServicePackage\Models\InstitutionType;

class InstitutionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Institution::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->word;
        $app_nature = json_decode(\Satis2020\ServicePackage\Models\Metadata::where('name', 'app-nature')->first()->data);
        $institutionType = $app_nature === "hub"
            ? InstitutionType::where('name', 'membre')->first()
            : InstitutionType::where('name', 'filiale')->first();

        return [
            'id' => (string)Str::uuid(),
            'slug' => Str::slug($name),
            'name' => $name,
            'acronyme' => $this->faker->randomLetter,
            'iso_code' => $this->faker->iso8601,
            'institution_type_id' => $institutionType->id
        ];
    }
}
