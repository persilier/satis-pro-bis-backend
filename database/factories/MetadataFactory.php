<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetadataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = MetaData::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => 'models',
            'data' => [
                [
                    "name" => 'users',
                    "description" => "model users",
                    "fonctions" => "models/fonction1"
                ],
                [
                    "name" => 'institutions',
                    "description" => "models institutions",
                    "fonctions" => "models/fonction2"
                ]
            ],
        ];
    }
}
