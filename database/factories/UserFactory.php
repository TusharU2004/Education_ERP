<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
     * @return array
     */
    public function definition()
    {
        return [
            'usertype' => $this->faker->randomElement(['Student','Employee']),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or bcrypt('password')
            'mobile' => $this->faker->numerify('98########'),
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'image' => $this->faker->imageUrl(),
            'fname' => $this->faker->firstName(),
            'lname' => $this->faker->lastName,
            'religion' => $this->faker->randomElement(['Hindu']),
            'id_no' => $this->faker->unique()->numerify('2025####'),
            'dob' => $this->faker->date('Y-m-d', '2005-01-01'),
            'code' => $this->faker->numerify('####'),
            'role' => $this->faker->randomElement(['Admin','SuperAdmin','Principle','Accountant']),
        ];
    }
}
