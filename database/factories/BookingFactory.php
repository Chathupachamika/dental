<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;

class BookingFactory extends Factory
{
    protected $model = Booking::class;



    public function definition()
    {
        return [
            'booking_id' => $this->faker->uuid,
            'customer_full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'contact_number' => $this->faker->phoneNumber,
            'request_type' => $this->faker->randomElement([
                'Wedding Car',
                'Travel & Tourism',
                'Business & Executive',
                'Economy & Budget Rentals',
                'Special Needs',
                'Others'
            ]),
            'pick_date' => $this->faker->date,
            'pick_time' => $this->faker->time,
            'return_date' => $this->faker->date,
            'return_time' => $this->faker->time,
            'location' => $this->faker->address,
            'driver_option' => $this->faker->randomElement(['With Driver', 'Without Driver']),
            'vehicle_id' => Vehicle::factory()->create()->car_id, // Ensure it retrieves actual ID
            'driver_id' => Driver::factory()->create()->driver_id, // Ensure it retrieves actual ID
            'nic_number' => $this->faker->numerify('#########V'),
            'test_filter_status' => $this->faker->randomElement(['Booked', 'Active', 'Completed', 'Cancelled']),
        ];
    }
}
