<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles';
    protected $primaryKey = 'car_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'car_id', 'car_type', 'model', 'type', 'image', 'engine_number', 'year', 'vin',
        'number_of_passenger', 'transmission_type', 'fuel', 'daily_rate', 'monthly_rate',
        'rated_weight_capacity', 'number_plate', 'free_mileage', 'color', 'category',
        'description', 'status', 'owner_name', 'owner_address', 'owner_contact', 'owner_email'
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'rated_weight_capacity' => 'decimal:2',
        'number_of_passenger' => 'integer',
        'year' => 'integer',
        'free_mileage' => 'integer',
        'image' => 'array', // Assuming multiple images stored as JSON
    ];

    protected static function booted()
    {
        static::creating(function ($vehicle) {
            if (!$vehicle->car_id) {
                $lastCar = self::orderBy('car_id', 'desc')->first();
                $lastCarId = $lastCar ? (int) substr($lastCar->car_id, 1) : 0;
                $vehicle->car_id = 'V' . str_pad($lastCarId + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicle_id', 'car_id');
    }
}
