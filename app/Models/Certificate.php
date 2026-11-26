<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no',
        'enrollment_id',
        'type',
        'issue_date',
        'remarks',
        'issued_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(StudentEnrollment::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Certificate Types
    public static function types(): array
    {
        return [
            'testimonial' => 'Testimonial',
            'character' => 'Character Certificate',
            'result' => 'Result Certificate',
            'transfer' => 'Transfer Certificate',
        ];
    }

    // Auto-generate Certificate Number
    public static function generateCertificateNo(): string
    {
        $prefix = 'CERT-' . date('Ymd') . '-';

        // Find the last certificate with today's date prefix
        $last = static::where('certificate_no', 'like', $prefix . '%')
            ->orderBy('certificate_no', 'desc')
            ->first();

        // Extract the last 4 digits and increment
        if ($last) {
            $lastNumber = (int) substr($last->certificate_no, -4);
            $number = $lastNumber + 1;
        } else {
            $number = 1;
        }

        // Format as 4 digits: CERT-20261126-0001
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Helper: Badge color for type
    public function getTypeBadgeAttribute(): string
    {
        return match ($this->type) {
            'testimonial' => 'primary',
            'character' => 'success',
            'result' => 'info',
            'transfer' => 'warning',
            default => 'secondary',
        };
    }
}