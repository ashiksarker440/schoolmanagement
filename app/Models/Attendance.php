<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'enrollment_id',
        'attendance_date',
        'status',
        'remarks',
        'marked_by',
        'updated_by',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'status' => 'integer',
    ];

    public function enrollment()
    {
        return $this->belongsTo(
            StudentEnrollment::class,
            'enrollment_id'
        );
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            1 => 'Present',
            0 => 'Absent',
            2 => 'Late',
            default => 'Unknown',
        };
    }
}
