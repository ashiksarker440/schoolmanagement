<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'total_amount',
        'due_date',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Student Enrollment Relationship
    public function enrollment()
    {
        return $this->belongsTo(StudentEnrollment::class, 'enrollment_id');
    }


    // Fee Payment Relationship
    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }

    public function details()
    {
        return $this->hasMany(FeeDetail::class);
    }

    // Total Paid Amount
    public function getPaidTotalAttribute()
    {
        return $this->payments->sum('payment_amount');
    }

    // Remaining Due Amount
    public function getDueTotalAttribute()
    {
        return max($this->total_amount - $this->paid_total, 0);
    }

    // Status Badge
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'success',
            'partial' => 'warning',
            'unpaid' => 'danger',
            default => 'secondary',
        };
    }

    // Automatically Update Status Based on Payments
    public function refreshStatus(): void
    {
        $paid = $this->paid_total;

        $status = 'unpaid';

        if ($paid >= $this->total_amount) {
            $status = 'paid';
        } elseif ($paid > 0) {
            $status = 'partial';
        }

        $this->update([
            'status' => $status
        ]);
    }
}
