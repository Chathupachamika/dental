<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\QueryException;
use PHPUnit\Framework\Attributes\Test;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure related models exist before each test
        $this->vehicle = Vehicle::factory()->create();
        $this->driver = Driver::factory()->create();
    }

    #[Test]
    public function it_can_create_a_booking()
    {
        $booking = Booking::factory()->create([
            'vehicle_id' => $this->vehicle->car_id,
            'driver_id' => $this->driver->driver_id,
        ]);

        $this->assertDatabaseHas('booking', [ // Ensure checking 'booking' and not 'bookings'
            'booking_id' => $booking->booking_id,
            'email' => $booking->email,
            'contact_number' => $booking->contact_number,
        ]);
    }

    #[Test]
    public function it_ensures_email_is_unique()
    {
        Booking::factory()->create([
            'email' => 'test@example.com',
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $this->expectException(QueryException::class);

        Booking::factory()->create([
            'email' => 'test@example.com',
            'vehicle_id' => $this->vehicle->car_id,
        ]);
    }

    #[Test]
    public function it_ensures_nic_number_is_unique()
    {
        Booking::factory()->create([
            'nic_number' => '123456789V',
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $this->expectException(QueryException::class);

        Booking::factory()->create([
            'nic_number' => '123456789V',
            'vehicle_id' => $this->vehicle->car_id,
        ]);
    }

    #[Test]
    public function it_can_update_a_booking()
    {
        $booking = Booking::factory()->create([
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $booking->update(['customer_full_name' => 'Updated Name']);

        $this->assertDatabaseHas('booking', [
            'booking_id' => $booking->booking_id,
            'customer_full_name' => 'Updated Name',
        ]);
    }

    #[Test]
    public function it_can_delete_a_booking()
    {
        $booking = Booking::factory()->create([
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $booking->delete();

        $this->assertSoftDeleted('booking', [
            'booking_id' => $booking->booking_id,
        ]);
    }

    #[Test]
    public function it_can_list_bookings()
    {
        Booking::factory()->count(3)->create([
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $this->assertCount(3, Booking::all());
    }

    #[Test]
    public function it_can_filter_bookings_by_status()
    {
        Booking::factory()->create([
            'test_filter_status' => 'Booked',
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        Booking::factory()->create([
            'test_filter_status' => 'Completed',
            'vehicle_id' => $this->vehicle->car_id,
        ]);

        $filteredBookings = Booking::where('test_filter_status', 'Booked')->get();

        $this->assertCount(1, $filteredBookings);
        $this->assertEquals('Booked', $filteredBookings->first()->test_filter_status);
    }
}