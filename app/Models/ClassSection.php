<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_sections');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
