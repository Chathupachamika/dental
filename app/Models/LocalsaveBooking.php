<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalSaveBooking extends Model
{
    protected $table = 'localsave_bookings';

    protected $fillable = [
        'customer_full_name', 'email', 'contact_number', 'request_type',
        'pick_date', 'pick_time', 'return_date', 'return_time', 'location',
        'driver_option', 'nic_number'
    ];
}
