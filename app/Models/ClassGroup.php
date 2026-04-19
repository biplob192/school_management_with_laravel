<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
