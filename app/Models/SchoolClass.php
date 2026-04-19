<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    public function classGroups()
    {
        return $this->hasMany(ClassGroup::class, 'class_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'class_groups', 'class_id', 'group_id');
    }

    public function classSections()
    {
        return $this->hasMany(ClassSection::class, 'class_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'class_sections', 'class_id', 'section_id');
    }
}
