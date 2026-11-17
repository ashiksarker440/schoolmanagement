<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'religion',
        'birth_certificate',
        'photo',
        'blood_group',
        'father_name',
        'father_profession',
        'father_phone',
        'mother_name',
        'mother_profession',
        'mother_phone',
        'guardian_name',
        'guardian_phone',
        'date_of_birth',
        'address'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];



    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    public function enrollment()
    {
        return $this->hasOne(StudentEnrollment::class)->latestOfMany();
    }
}