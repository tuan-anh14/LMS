<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name'];

    //attr

    //scope
    public function scopeWhenProjectId($query, $projectId)
    {
        return $query->when($projectId, function ($q) use ($projectId) {

            return $q->where('project_id', $projectId);

        });

    }// end of scopeWhenProjectId

    //rel
    public function project()
    {
        return $this->belongsTo(Project::class);

    }// end of project

    public function studentExams()
    {
        return $this->hasMany(StudentExam::class);

    }// end of studentExams

    //fun

}//end of model
