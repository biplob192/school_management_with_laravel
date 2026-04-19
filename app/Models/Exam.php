<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
