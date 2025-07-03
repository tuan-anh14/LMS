<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSection extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'section_id', 'center_id'];

    //attr

    //scope

    //rel
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');

    }// end of student

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');

    }// end of section

    //fun

}//end of model
