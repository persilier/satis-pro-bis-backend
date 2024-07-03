<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Satis2020\ServicePackage\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaimFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

     protected $model = Claim::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nature = env('APP_NATURE');

        if ($nature === 'DEVELOP') {

            $user = User::with('identite.staff')->find('8df01ee3-7f66-4328-9510-f75666f4bc4a');
        }

        if ($nature === 'MACRO') {

            $user = $this->faker->randomElement([true, false])
                ? User::with('identite.staff')->find('6f53d239-2890-4faf-9af9-f5a97aee881e')
                : User::with('identite.staff')->find('ceefcca8-35c6-4e62-9809-42bf6b9adb20');
        }

        if ($nature == 'HUB') {

            $user = User::with('identite.staff')->find('94656cd3-d0c7-45bb-83b6-5ded02ded07b');
        }

        if ($nature == 'PRO') {

            $user = User::with('identite.staff')->find('18732c5e-b485-474e-811d-de9bbb8d6cf2');
        }

        $sexe = $this->faker->randomElement(['male', 'female']);
        $claimer = \Satis2020\ServicePackage\Models\Identite::create([
            'firstname' => $this->faker->firstName($sexe),
            'lastname' => $this->faker->lastName,
            'sexe' => strtoupper(substr($sexe, 0, 1)),
            'telephone' => [$this->faker->phoneNumber],
            'email' => [$this->faker->safeEmail]
        ]);

        return [
            'id' => (string)Str::uuid(),
            'description' => $this->faker->text,
            'claim_object_id' => \Satis2020\ServicePackage\Models\ClaimObject::all()->random()->id,
            'claimer_id' => $claimer->id,
            'institution_targeted_id' => \Satis2020\ServicePackage\Models\Institution::all()->random()->id,
            'request_channel_slug' => \Satis2020\ServicePackage\Models\Channel::all()->random()->slug,
            'response_channel_slug' => \Satis2020\ServicePackage\Models\Channel::where('is_response', true)->get()->random()->slug,
            'event_occured_at' => $this->faker->date('Y-m-d H:i:s'),
            'amount_disputed' => $this->faker->numberBetween(50000, 1000000),
            'amount_currency_slug' => \Satis2020\ServicePackage\Models\Currency::all()->random()->slug,
            'is_revival' => $this->faker->randomElement([true, false]),
            'created_by' => $user->identite->staff->id,
            'status' => 'full',
            'reference' => date('Y') . date('m') . '-' . $this->faker->randomNumber(6, true),
            'claimer_expectation' => $this->faker->text
        ];
    }
}
