<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    protected $casts = [
        'enrollment_date' => 'date',
    ];

    protected $fillable = [
        'student_id',
        'student_session_id',
        'class_id',
        'section_id',
        'shift_id',
        'group_id',
        'roll_no',
        'enrollment_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'enrollment_id');
    }
}
