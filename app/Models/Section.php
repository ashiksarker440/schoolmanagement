<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id', 'capacity', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}