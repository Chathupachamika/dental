<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'otherNote',
        'visitDate',
        'totalAmount',
        'advanceAmount',
        'patient'
    ];
    public function invoiceTreatment()
    {
        return $this->hasMany(InvoiceTreatment::class);
    }
    public function patient()
    {
        return $this->belongsTo(patient::class);
    }
}
