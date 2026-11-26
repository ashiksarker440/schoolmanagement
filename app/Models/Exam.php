<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'session_id', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function session()
    {
        return $this->belongsTo(StudentSession::class, 'session_id');
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }
}