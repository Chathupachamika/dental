<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'car_id' => $this->faker->unique()->word(),
            'car_type' => $this->faker->randomElement(['SEDAN', 'COUPE', 'SPORTS CAR', 'STATION WAGON', 'HATCHBACK', 'CONVERTIBLE', 'SPORT-UTILITY VEHICLE', 'MINIVAN', 'VAN', 'PICKUP TRUCK', 'OTHER']),
            'model' => $this->faker->word(),
            'type' => $this->faker->randomElement(['Car', 'Van', 'Other']),
            'image' => $this->faker->imageUrl(),
            'engine_number' => $this->faker->unique()->word(),
            'year' => $this->faker->year(),
            'vin' => $this->faker->unique()->word(),
            'number_of_passenger' => $this->faker->numberBetween(1, 7),
            'transmission_type' => $this->faker->randomElement(['Manual', 'Automatic']),
            'fuel' => $this->faker->randomElement(['Diesel', 'Petrol', 'Hybrid', 'Electric']),
            'daily_rate' => $this->faker->randomFloat(2, 10, 200),
            'monthly_rate' => $this->faker->randomFloat(2, 100, 3000),
            'rated_weight_capacity' => $this->faker->randomFloat(2, 500, 3000),
            'number_plate' => $this->faker->unique()->word(),
            'free_mileage' => $this->faker->numberBetween(100, 1000),
            'color' => $this->faker->colorName(),
            'category' => $this->faker->randomElement(['Wedding Car', 'Travel & Tourism', 'Business & Executive', 'Economy & Budget Rentals', 'Special Needs', 'Others']),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['Available', 'Booked', 'Non-Available']),
            'owner_name' => $this->faker->name(),
            'owner_address' => $this->faker->address(),
            'owner_contact' => $this->faker->phoneNumber(),
            'owner_email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
