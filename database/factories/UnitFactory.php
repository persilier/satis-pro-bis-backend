<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $units = \Satis2020\ServicePackage\Models\Unit::with('unitType.child')->get()->filter(function ($value, $key) {
            return !is_null($value->unitType->children);
        });

        $parent = $units->count() > 0
            ? $units->random()
            : null;

        $app_nature = json_decode(\Satis2020\ServicePackage\Models\Metadata::where('name', 'app-nature')->first()->data);

        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->text,    
            'unit_type_id' => is_null($parent) ? \Satis2020\ServicePackage\Models\UnitType::whereNull('parent_id')->first()->id : Arr::random($parent->unitType->children)->id,
            'parent_id' => is_null($parent) ? null : $parent->id,
            'institution_id' => $app_nature === 'hub' ? null : \Satis2020\ServicePackage\Models\Institution::all()->random()->id
        ];
    }
}
