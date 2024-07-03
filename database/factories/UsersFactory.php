<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersFactory extends Factory
{
        /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $staff = \Satis2020\ServicePackage\Models\Staff::with('identite.user')->get()->filter(function ($value, $key) {
            return is_null($value->identite->user);
        })->random();

        return [
            'id' => (string) Str::uuid(),
            'username' => $staff->identite->email[0],
            'password' => bcrypt('123456789'),
            'identite_id' => $staff->identite->id,
            'disabled_at' => null
        ];
    }
}
