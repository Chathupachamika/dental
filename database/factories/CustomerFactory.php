<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'customer_id' => $this->faker->unique()->word(),
            'customer_full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_number' => $this->faker->phoneNumber(),
            'request_type' => $this->faker->randomElement([
                'Wedding Car',
                'Travel & Tourism',
                'Business & Executive',
                'Economy & Budget Rentals',
                'Special Needs',
                'Others'
            ]),
            'vehicle_name' => $this->faker->word(),
            'vehicle_id' => Vehicle::factory()->create()->car_id, // Ensures valid foreign key
            'driver_first_name' => $this->faker->firstName(),
            'driver_id' => Driver::factory()->create()->driver_id, // Ensures valid foreign key
            'pick_time_date' => $this->faker->dateTime(),
            'return_time_date' => $this->faker->dateTime(),
            'nic_number' => $this->faker->unique()->regexify('[0-9]{9}[Vv]'),
            'nic_front_image' => null,
            'nic_back_image' => null,
            'test_filter_status' => $this->faker->randomElement(['Booked', 'Active', 'Completed', 'Cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
