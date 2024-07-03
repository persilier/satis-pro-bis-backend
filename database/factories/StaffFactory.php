<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $app_nature = json_decode(\Satis2020\ServicePackage\Models\Metadata::where('name', 'app-nature')->first()->data);

        $institution = $app_nature === "hub"
            ? \Satis2020\ServicePackage\Models\Institution::all()->random()
            : \Satis2020\ServicePackage\Models\Institution::with(['units', 'positions'])->get()->filter(function ($value, $key) {
                return count($value->units) !== 0 && count($value->positions) !== 0;
            })->random();

        $unit = null;
        if ($app_nature === "hub" && \Satis2020\ServicePackage\Models\Unit::all()->count() > 0) {
            $unit = \Satis2020\ServicePackage\Models\Unit::all()->random();
        } elseif ($app_nature !== "hub") {
            $unit = Arr::random($institution->units->all());
        }

        $identites = \Satis2020\ServicePackage\Models\Identite::with('staff')->get()->filter(function ($value, $key) {
            return is_null($value->staff);
        });

        return [
            'id' => (string)Str::uuid(),
            'identite_id' => $identites->random()->id,
            'position_id' => $app_nature === "hub" ? \Satis2020\ServicePackage\Models\Position::all()->random()->id : Arr::random($institution->positions->all())->id,
            'institution_id' => $institution->id,
            'unit_id' => is_null($unit)
                ? null
                : $unit->id,
        ];
    }
}
