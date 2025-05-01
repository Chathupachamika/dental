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
        'invoice',
        'user_id' // Add user_id to fillable
    ];
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
