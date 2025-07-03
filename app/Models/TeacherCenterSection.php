<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeacherCenterSection extends Pivot
{
    protected $fillable = ['teacher_id', 'center_id', 'grade_id'];

    //attr

    //scope

    //rel
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }// end of teacher

    //fun

}//end of model
