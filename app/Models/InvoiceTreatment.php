<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTreatment extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'treatMent',
    ];
    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
