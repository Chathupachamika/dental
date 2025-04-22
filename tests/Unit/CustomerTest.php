<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\QueryException;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_customer()
    {
        $customer = Customer::factory()->create();

        $this->assertDatabaseHas('customers', [
            'customer_id' => $customer->customer_id,
            'email' => $customer->email,
            'contact_number' => $customer->contact_number,
        ]);
    }

    public function test_can_update_customer()
    {
        $customer = Customer::factory()->create();

        $customer->update(['customer_full_name' => 'Updated Name']);

        $this->assertDatabaseHas('customers', [
            'customer_id' => $customer->customer_id,
            'customer_full_name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $customer->delete();

        $this->assertSoftDeleted('customers', [
            'customer_id' => $customer->customer_id,
        ]);
    }

    public function test_can_retrieve_customer()
    {
        $customer = Customer::factory()->create();

        $retrievedCustomer = Customer::find($customer->customer_id);

        $this->assertEquals($customer->customer_id, $retrievedCustomer->customer_id);
    }

    public function test_can_list_customers()
    {
        Customer::factory()->count(3)->create();

        $this->assertCount(3, Customer::all());
    }

    public function test_can_filter_customers_by_email()
    {
        $customer1 = Customer::factory()->create(['email' => 'user1@example.com']);
        $customer2 = Customer::factory()->create(['email' => 'user2@example.com']);

        $filteredCustomers = Customer::where('email', 'user1@example.com')->get();

        $this->assertCount(1, $filteredCustomers);
        $this->assertEquals('user1@example.com', $filteredCustomers->first()->email);
    }

    public function test_ensures_email_is_unique()
    {
        Customer::factory()->create(['email' => 'test@example.com']);

        $this->expectException(QueryException::class);

        Customer::factory()->create(['email' => 'test@example.com']);
    }

    public function test_ensures_nic_number_is_unique()
    {
        Customer::factory()->create(['nic_number' => '123456789V']);

        $this->expectException(QueryException::class);

        Customer::factory()->create(['nic_number' => '123456789V']);
    }
}
