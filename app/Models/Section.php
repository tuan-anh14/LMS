<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['center_id', 'project_id', 'name'];

    //attr

    //scope
    public function scopeWhenCenterId($query, $centerId)
    {
        return $query->when($centerId, function ($q) use ($centerId) {

            return $q->where('center_id', $centerId);

        });

    }// end of scopeWhenCenterId

    public function scopeWhenProjectId($query, $projectId)
    {
        return $query->when($projectId, function ($q) use ($projectId) {

            return $q->where('project_id', $projectId);

        });

    }// end of scopeWhenProjectId


    //rel
    public function center()
    {
        return $this->belongsTo(Center::class);

    }// end of center

    public function project()
    {
        return $this->belongsTo(Project::class);

    }// end of project

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_center_section', 'section_id', 'teacher_id');

    }// end of teachers

    public function students()
    {
        return $this->hasMany(User::class, 'student_section_id');

    }// end of students


    //fun
    public function canBeDeleted()
    {
        return $this->teachers->count() == 0 && $this->students->count() == 0;

    }// end of canBeDeleted

}//end of model
