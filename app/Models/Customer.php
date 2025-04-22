<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'customer_full_name',
        'email',
        'contact_number',
        'request_type',
        'vehicle_name',
        'vehicle_id',
        'driver_first_name',
        'driver_id',
        'pick_time_date',
        'return_time_date',
        'nic_number',
        'nic_front_image',
        'nic_back_image',
        'test_filter_status'
    ];

    protected $casts = [
        'pick_time_date' => 'datetime',
        'return_time_date' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($customer) {
            // Generate new customer_id only if not exists
            if (!Customer::where('email', $customer->email)->exists()) {
                $lastCustomer = self::orderBy('customer_id', 'desc')->first();
                $lastId = $lastCustomer ? (int) substr($lastCustomer->customer_id, 1) : 0;
                $customer->customer_id = 'C' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            }
            if (!$customer->test_filter_status) {
                $customer->test_filter_status = 'Booked';
            }
        });

        static::updating(function ($customer) {
            if ($customer->isDirty('test_filter_status')) {
                DB::transaction(function () use ($customer) {
                    $newStatus = $customer->test_filter_status;
                    $originalStatus = $customer->getOriginal('test_filter_status');

                    // Sync status to related bookings
                    Booking::where('customer_full_name', $customer->customer_full_name)
                        ->where('email', $customer->email)
                        ->update(['test_filter_status' => $newStatus]);

                    // Update driver and vehicle availability if status changes to Completed or Cancelled
                    if (in_array($newStatus, ['Completed', 'Cancelled']) && !in_array($originalStatus, ['Completed', 'Cancelled'])) {
                        // Make driver available if assigned
                        if ($customer->driver_id) {
                            Driver::where('driver_id', $customer->driver_id)
                                ->update(['availability' => 'Available']);
                        }

                        // Make vehicle available if assigned
                        if ($customer->vehicle_id) {
                            Vehicle::where('car_id', $customer->vehicle_id)
                                ->update(['status' => 'Available']);
                        }
                    }
                });
            }
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'car_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_full_name', 'customer_full_name');
    }
}
