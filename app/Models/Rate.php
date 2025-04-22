<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    /** @use HasFactory<\Database\Factories\RateFactory> */
    use HasFactory;
    protected $table = 'rates';
    protected $primaryKey = 'rate_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded=[];

}
