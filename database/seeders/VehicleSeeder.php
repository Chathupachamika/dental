<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'car_id' => 'V0001',
                'car_type' => 'SEDAN',
                'model' => 'Toyota Camry',
                'type' => 'Car',
                'image' => ['camry.jpg'],
                'engine_number' => 'ENG00001',
                'year' => 2023,
                'vin' => 'VIN001CAM',
                'number_of_passenger' => 5,
                'transmission_type' => 'Automatic',
                'fuel' => 'Petrol',
                'daily_rate' => 75.00,
                'monthly_rate' => 1800.00,
                'rated_weight_capacity' => 450.00,
                'number_plate' => 'ABC123',
                'free_mileage' => 100,
                'color' => 'Silver',
                'category' => 'Business & Executive',
                'description' => 'Luxurious and comfortable sedan perfect for business travel',
                'status' => 'Available',
                'owner_name' => 'John Doe',
                'owner_address' => '123 Main St, City',
                'owner_contact' => '555-0123',
                'owner_email' => 'john@example.com'
            ],
            [
                'car_id' => 'V00002',
                'car_type' => 'SPORTS CAR',
                'model' => 'BMW M4',
                'type' => 'Car',
                'image' => ['m4.jpg'],
                'engine_number' => 'ENG00002',
                'year' => 2023,
                'vin' => 'VIN002BMW',
                'number_of_passenger' => 4,
                'transmission_type' => 'Automatic',
                'fuel' => 'Petrol',
                'daily_rate' => 150.00,
                'monthly_rate' => 3500.00,
                'rated_weight_capacity' => 400.00,
                'number_plate' => 'XYZ789',
                'free_mileage' => 80,
                'color' => 'Black',
                'category' => 'Wedding Car',
                'description' => 'High-performance luxury sports car',
                'status' => 'Available',
                'owner_name' => 'Jane Smith',
                'owner_address' => '456 Oak St, City',
                'owner_contact' => '555-0456',
                'owner_email' => 'jane@example.com'
            ],
            [
                'car_id' => 'V00003',
                'car_type' => 'VAN',
                'model' => 'Toyota HiAce',
                'type' => 'Van',
                'image' => ['hiace.jpg'],
                'engine_number' => 'ENG00003',
                'year' => 2022,
                'vin' => 'VIN003VAN',
                'number_of_passenger' => 12,
                'transmission_type' => 'Manual',
                'fuel' => 'Diesel',
                'daily_rate' => 100.00,
                'monthly_rate' => 2500.00,
                'rated_weight_capacity' => 1000.00,
                'number_plate' => 'DEF456',
                'free_mileage' => 150,
                'color' => 'White',
                'category' => 'Travel & Tourism',
                'description' => 'Spacious van perfect for group travel',
                'status' => 'Available',
                'owner_name' => 'Mike Johnson',
                'owner_address' => '789 Pine St, City',
                'owner_contact' => '555-0789',
                'owner_email' => 'mike@example.com'
            ]
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
