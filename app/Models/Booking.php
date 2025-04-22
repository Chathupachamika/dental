<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking';
    protected $primaryKey = 'booking_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'booking_id', 'customer_full_name', 'email', 'contact_number', 'request_type',
        'pick_date', 'pick_time', 'return_date', 'return_time', 'location', 'driver_option',
        'vehicle_id', 'driver_id', 'nic_number', 'nic_front_image', 'nic_back_image',
        'test_filter_status', 'pick_time_date', 'return_time_date', 'user_id', 'status'
    ];

    protected $casts = [
        'pick_date' => 'date',
        'pick_time' => 'datetime:H:i',
        'return_date' => 'date',
        'return_time' => 'datetime:H:i',
        'pick_time_date' => 'datetime',
        'return_time_date' => 'datetime',
        'driver_option' => 'string',
        'test_filter_status' => 'string',
        'status' => 'string'
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (!$booking->booking_id) {
                $lastBooking = self::withTrashed()->orderBy('booking_id', 'desc')->first();
                $lastId = $lastBooking ? (int) substr($lastBooking->booking_id, 3) : 0;
                $booking->booking_id = 'REQ' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
            }
            if (!$booking->test_filter_status) {
                $booking->test_filter_status = 'Booked';
            }
            // Only set driver_id to null if explicitly set to 'Without Driver'
            if ($booking->driver_option === 'Without Driver') {
                $booking->driver_id = null;
            }
            if (!$booking->status) {
                $booking->status = 'booked';
            }
        });

        static::created(function ($booking) {
            // Find existing customer or create new one
            $existingCustomer = Customer::where('email', $booking->email)
                ->where('customer_full_name', $booking->customer_full_name)
                ->first();

            if ($existingCustomer) {
                $existingCustomer->update([
                    'contact_number' => $booking->contact_number,
                    'request_type' => $booking->request_type,
                    'vehicle_name' => $booking->vehicle->model ?? null,
                    'vehicle_id' => $booking->vehicle_id,
                    'driver_first_name' => $booking->driver ? $booking->driver->first_name : null,
                    'driver_id' => $booking->driver_id,
                    'pick_time_date' => $booking->pick_time_date,
                    'return_time_date' => $booking->return_time_date,
                    'nic_number' => $booking->nic_number,
                    'nic_front_image' => $booking->nic_front_image,
                    'nic_back_image' => $booking->nic_back_image,
                    'test_filter_status' => $booking->test_filter_status,
                ]);
            } else {
                Customer::create([
                    'email' => $booking->email,
                    'customer_full_name' => $booking->customer_full_name,
                    'contact_number' => $booking->contact_number,
                    'request_type' => $booking->request_type,
                    'vehicle_name' => $booking->vehicle->model ?? null,
                    'vehicle_id' => $booking->vehicle_id,
                    'driver_first_name' => $booking->driver ? $booking->driver->first_name : null,
                    'driver_id' => $booking->driver_id,
                    'pick_time_date' => $booking->pick_time_date,
                    'return_time_date' => $booking->return_time_date,
                    'nic_number' => $booking->nic_number,
                    'nic_front_image' => $booking->nic_front_image,
                    'nic_back_image' => $booking->nic_back_image,
                    'test_filter_status' => $booking->test_filter_status,
                ]);
            }
        });

        static::updated(function ($booking) {
            if ($booking->isDirty()) {
                $customer = Customer::where('email', $booking->email)
                    ->where('customer_full_name', $booking->customer_full_name)
                    ->first();

                if ($customer) {
                    $customer->update([
                        'contact_number' => $booking->contact_number,
                        'request_type' => $booking->request_type,
                        'vehicle_name' => $booking->vehicle->model ?? null,
                        'vehicle_id' => $booking->vehicle_id,
                        'driver_first_name' => $booking->driver ? $booking->driver->first_name : null,
                        'driver_id' => $booking->driver_id,
                        'pick_time_date' => $booking->pick_time_date,
                        'return_time_date' => $booking->return_time_date,
                        'nic_number' => $booking->nic_number,
                        'nic_front_image' => $booking->nic_front_image,
                        'nic_back_image' => $booking->nic_back_image,
                        'test_filter_status' => $booking->test_filter_status,
                    ]);
                }
            }
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_full_name', 'customer_full_name');
    }
}
