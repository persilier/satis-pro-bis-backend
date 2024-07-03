<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $identites = \Satis2020\ServicePackage\Models\Identite::with('client-from-my-institution')->get()->filter(function ($value, $key) {
            return is_null($value->client);
        });

        return [
            'id' => (string) Str::uuid(),
            'type_clients_id' => \Satis2020\ServicePackage\Models\TypeClient::all()->random()->id,
            'category_clients_id' => \Satis2020\ServicePackage\Models\CategoryClient::all()->random()->id,
            'identites_id' => $identites->random()->id,
        ];
    }
}
