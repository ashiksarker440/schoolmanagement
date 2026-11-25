<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_id',
        'receipt_no',
        'payment_amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'received_by',
    ];

    protected $casts = [
        'payment_date'   => 'date',
        'payment_amount' => 'decimal:2',
    ];

    // Relationships
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    // Auto-generate receipt no
    public static function generateReceiptNo(): string
    {
        $prefix = 'RCP-' . date('Ymd') . '-';
        $last   = static::where('receipt_no', 'like', $prefix . '%')
                         ->orderBy('receipt_no', 'desc')
                         ->first();
        $number = $last ? ((int) substr($last->receipt_no, -4)) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}