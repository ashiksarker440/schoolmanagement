<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'phone',
        'email',
        'address',
        'qualification',
        'main_subject',
        'salary',
        'joining_date',
        'photo',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'teacher_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('storage/teachers/' . $this->photo))) {
            return asset('storage/teachers/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }
}