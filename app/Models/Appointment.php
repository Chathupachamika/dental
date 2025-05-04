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
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'user_id'
    ];

    protected $dates = [
        'visit_date', // Changed from visitDate
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function invoiceTreatment()
    {
        return $this->hasOne(InvoiceTreatment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get appointments by user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Get full appointment details
    public function getFullDetails()
    {
        return $this->load(['patient', 'invoiceTreatment.treatment']);
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

    /**
     * Get aggregated appointment statistics
     */
    public static function getStats()
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        return [
            'total' => static::count(),
            'pending' => static::where('status', 'pending')->count(),
            'confirmed' => static::where('status', 'confirmed')->count(),
            'cancelled' => static::where('status', 'cancelled')->count(),
            'today' => static::whereDate('appointment_date', $today)->count(),
            'thisWeek' => static::whereBetween('appointment_date', [$weekStart, $weekEnd])->count(),
            'thisMonth' => static::whereBetween('appointment_date', [$monthStart, $monthEnd])->count(),
        ];
    }

    /**
     * Get appointment data for calendar view
     */
    public static function getCalendarData()
    {
        $start = Carbon::now()->subMonths(3);
        $end = Carbon::now()->addMonths(3);

        return static::whereBetween('appointment_date', [$start, $end])
            ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->map(function($item) {
                return [$item->date, $item->count];
            });
    }
}
