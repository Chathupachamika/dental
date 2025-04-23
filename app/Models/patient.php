<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'mobileNumber',
        'age',
        'gender',
        'nic',
        'invoice'
    ];
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
