<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Driver;
use Illuminate\Database\QueryException;

class DriverTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_driver()
    {
        $driver = Driver::factory()->create();

        $this->assertDatabaseHas('drivers', [
            'driver_id' => $driver->driver_id,
            'email' => $driver->email,
            'contact_number' => $driver->contact_number,
        ]);
    }

    public function test_can_update_driver()
    {
        $driver = Driver::factory()->create();

        $driver->update(['first_name' => 'Updated Name']);

        $this->assertDatabaseHas('drivers', [
            'driver_id' => $driver->driver_id,
            'first_name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_driver()
    {
        $driver = Driver::factory()->create();

        $driver->delete();

        $this->assertSoftDeleted('drivers', [
            'driver_id' => $driver->driver_id,
        ]);
    }

    public function test_can_retrieve_driver()
    {
        $driver = Driver::factory()->create();

        $retrievedDriver = Driver::find($driver->driver_id);

        $this->assertEquals($driver->driver_id, $retrievedDriver->driver_id);
    }

    public function test_can_list_drivers()
    {
        Driver::factory()->count(3)->create();

        $this->assertCount(3, Driver::all());
    }

    public function test_ensures_email_is_unique()
    {
        Driver::factory()->create(['email' => 'test@example.com']);

        $this->expectException(QueryException::class);

        Driver::factory()->create(['email' => 'test@example.com']);
    }

    public function test_ensures_nic_number_is_unique()
    {
        Driver::factory()->create(['nic_number' => '123456789V']);

        $this->expectException(QueryException::class);

        Driver::factory()->create(['nic_number' => '123456789V']);
    }

    public function test_ensures_license_id_is_unique()
    {
        Driver::factory()->create(['license_id' => 'LIC123456']);

        $this->expectException(QueryException::class);

        Driver::factory()->create(['license_id' => 'LIC123456']);
    }

    public function test_sets_default_availability()
    {
        $driver = Driver::factory()->create();

        $this->assertEquals('Available', $driver->availability);
    }
}
