<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model  // Changed from 'patient' to 'Patient'
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'mobileNumber',
        'age',
        'gender',
        'nic',
        'user_id'
    ];

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function treatments()
    {
        return $this->hasManyThrough(
            InvoiceTreatment::class,
            Invoice::class,
            'patient_id',
            'invoice_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get all patient details including treatments
    public function getFullDetails()
    {
        return $this->load(['invoices.invoiceTreatment', 'appointments']);
    }
}
