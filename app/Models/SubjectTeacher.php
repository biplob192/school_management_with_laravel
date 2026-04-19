<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    protected $fillable = [
        'subject_id',
        'group_id',
        'is_common_section_teacher',
        'section_id',
        'teacher_id',
        'shift',
        'role',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
