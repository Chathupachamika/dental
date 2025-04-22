<?php

namespace Tests\Unit;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class VehicleTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_create_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $this->assertDatabaseHas('vehicles', [
            'car_id' => $vehicle->car_id,
            'model' => $vehicle->model,
        ]);
    }


    public function test_can_update_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $vehicle->update(['model' => 'Updated Model']);

        $this->assertDatabaseHas('vehicles', [
            'car_id' => $vehicle->car_id,
            'model' => 'Updated Model',
        ]);
    }


    public function test_can_delete_vehicle()
    {
        $vehicle = Vehicle::factory()->create();

        $vehicle->delete();

        $this->assertSoftDeleted('vehicles', [
            'car_id' => $vehicle->car_id,
        ]);
    }


    public function test_can_retrieve_vehicle()
    {
        $vehicle = Vehicle::factory()->create();


        $retrievedVehicle = Vehicle::find($vehicle->car_id);


        $this->assertEquals($vehicle->car_id, $retrievedVehicle->car_id);
    }



    public function test_can_list_vehicles()
    {
        $vehicles = Vehicle::factory()->count(3)->create();

        $this->assertCount(3, Vehicle::all());
    }

    public function test_can_filter_vehicles_by_model()
    {
        $vehicle1 = Vehicle::factory()->create(['model' => 'Model A']);
        $vehicle2 = Vehicle::factory()->create(['model' => 'Model B']);

        $filteredVehicles = Vehicle::where('model', 'Model A')->get();

        $this->assertCount(1, $filteredVehicles);
        $this->assertEquals('Model A', $filteredVehicles->first()->model);
    }


    public function test_vehicle_creation_with_default_car_id()
    {
        $vehicle = Vehicle::factory()->create(['car_id' => null]);

        $this->assertNotNull($vehicle->car_id);
        $this->assertStringStartsWith('V', $vehicle->car_id);
    }
}
