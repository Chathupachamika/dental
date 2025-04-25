<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'visitDate',
        'totalAmount',
        'advanceAmount',
        'otherNote',
        'status'
    ];

    protected $dates = [
        'visitDate',
        'created_at',
        'updated_at'
    ];

    // Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relationship with InvoiceTreatment
    public function invoiceTreatment()
    {
        return $this->hasMany(InvoiceTreatment::class);
    }

    // Check if appointment is pending
    public function isPending()
    {
        return strpos($this->otherNote ?? '', 'Booked by user') !== false && $this->totalAmount == 0;
    }

    // Check if appointment is cancelled
    public function isCancelled()
    {
        return strpos($this->otherNote ?? '', 'Cancelled') !== false;
    }

    // Check if appointment is user booked
    public function isUserBooked()
    {
        return strpos($this->otherNote ?? '', 'Booked by user') !== false;
    }

    // Get appointment status
    public function getStatus()
    {
        if ($this->isCancelled()) {
            return 'Cancelled';
        } elseif ($this->isPending()) {
            return 'Pending';
        } elseif (Carbon::parse($this->visitDate)->isPast()) {
            return 'Completed';
        }
        return 'Confirmed';
    }
}
