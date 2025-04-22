<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'driver_id' => $this->faker->unique()->word(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),
            'nic_number' => $this->faker->unique()->regexify('[0-9]{9}[Vv]'),
            'address' => $this->faker->address(),
            'license_type' => $this->faker->randomElement(['A', 'B', 'C']),
            'license_id' => $this->faker->unique()->word(),
            'license_expiry_date' => $this->faker->date('Y-m-d', '2030-12-31'),
            'license_front_image' => null,
            'license_back_image' => null,
            'availability' => 'Available',
        ];
    }
}
