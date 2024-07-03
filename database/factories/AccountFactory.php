<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $clients = \Satis2020\ServicePackage\Models\Client::doesntHave('accounts')->get();
        return [
            'id' => (string) Str::uuid(),
            'client_id' => $clients->random()->id,
            'institution_id' => \Satis2020\ServicePackage\Models\Institution::all()->random()->id,
            'account_type_id' => \Satis2020\ServicePackage\Models\AccountType::all()->random()->id,
            'number' => $this->faker->bankAccountNumber,
        ];
    }
}
