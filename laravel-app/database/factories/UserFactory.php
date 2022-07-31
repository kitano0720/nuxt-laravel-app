<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement($array = [true, false]);

        return [
            'name' => $this->faker->unique()->name($gender ? 'male' : 'female'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'age' => $this->faker->numberBetween(18, 70),
            'gender' => $gender,
        ];
    }
}
