<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'center_id', 'project_id', 'section_id', 'action_by_user_id'];

    //attr

    //scope
    public function scopeWhenStudentId($query, $studentId)
    {
        return $query->when($studentId, function ($q) use ($studentId) {

            return $q->where('student_id', $studentId);

        });

    }// end of scopeWhenStudentId

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

    public function scopeWhenSectionId($query, $sectionId)
    {
        return $query->when($sectionId, function ($q) use ($sectionId) {

            return $q->where('section_id', $sectionId);

        });

    }// end of scopeWhenSectionId


    //rel
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');

    }// end of student

    public function center()
    {
        return $this->belongsTo(Center::class);

    }// end of center

    public function project()
    {
        return $this->belongsTo(Project::class);

    }// end of project

    public function section()
    {
        return $this->belongsTo(Section::class);

    }// end of section

    public function actionByUser()
    {
        return $this->belongsTo(User::class, 'action_by_user_id');

    }// end of actionByUser

    //fum

}//end of model
