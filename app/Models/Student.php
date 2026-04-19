<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'class_id',
        'section_id',
        'date_of_birth',
        'gender',
        'address',
        'guardian_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
