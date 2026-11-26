<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'code',
        'mark_type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function markTypes(): array
    {
        return [
            '1' => 'Written',
            '2' => 'MCQ + Practical',
            '3' => 'Written + Practical',
            '4' => 'Written + MCQ',
            '5' => 'Written + MCQ + Practical',
        ];
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }
}