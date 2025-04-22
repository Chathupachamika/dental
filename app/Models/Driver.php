<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'driver_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'driver_id',
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'nic_number',
        'address',
        'license_type',
        'license_id',
        'license_expiry_date',
        'license_front_image',
        'license_back_image',
        'availability'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($driver) {
            if (!$driver->driver_id) {
                $driver->driver_id = self::generateDriverId();
            }
        });
    }

    protected static function generateDriverId()
    {
        $existingIds = self::pluck('driver_id')->map(function ($id) {
            return (int) substr($id, 3);
        })->toArray();

        $number = empty($existingIds) ? 1 : (max($existingIds) + 1);
        return 'DRV' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
