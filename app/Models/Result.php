<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['enrollment_id', 'exam_subject_id', 'obtained_marks', 'status'];

    protected $casts = [
        'obtained_marks' => 'decimal:2',
    ];

    public function enrollment()
    {
        return $this->belongsTo(StudentEnrollment::class);
    }

    public function examSubject()
    {
        return $this->belongsTo(ExamSubject::class);
    }

    // Bangladesh GPA Grade
    public function getGradeAttribute(): string
    {
        if ($this->status === 'absent') return 'F';

        $percent = ($this->obtained_marks / $this->examSubject->full_marks) * 100;

        return match(true) {
            $percent >= 80 => 'A+',
            $percent >= 70 => 'A',
            $percent >= 60 => 'A-',
            $percent >= 50 => 'B',
            $percent >= 40 => 'C',
            $percent >= 33 => 'D',
            default        => 'F',
        };
    }

    public function getGradePointAttribute(): float
    {
        return match($this->grade) {
            'A+' => 5.00, 'A' => 4.00, 'A-' => 3.50,
            'B'  => 3.00, 'C' => 2.00, 'D' => 1.00,
            default => 0.00,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pass' => 'success',
            'fail' => 'danger',
            'absent' => 'warning',
            default => 'secondary',
        };
    }
}