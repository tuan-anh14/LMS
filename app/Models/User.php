<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lab404\Impersonate\Models\Impersonate;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Notifiable, LaratrustUserTrait, Impersonate;

    protected $fillable = [
        'country_id', 'governorate_id', 'degree_id', 'student_center_id', 'student_section_id',
        'student_project_id', 'first_name', 'second_name', 'nickname', 'email', 'mobile', 'email_verified_at', 'password',
        'type', 'image', 'locale', 'address', 'reading_type',
        'dob', 'gender', 'is_examiner', 'registration_date',
    ];

    protected $appends = ['image_path'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'registration_date' => 'datetime',
    ];

    //atr
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);

    }// end of getNameAttribute

    public function getSecondNameAttribute($value)
    {
        return ucfirst($value);

    }// end of getSecondNameAttribute

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->second_name . ' (' . $this->nickname . ')';

    }// end of getNameFullAttribute

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return Storage::url('uploads/' . $this->image);
        }

        return asset('images/default.jpg');

    }// end of getImagePathAttribute

    //scope
    public function scopeWhenRoleId($query, $roleId)
    {
        return $query->when($roleId, function ($q) use ($roleId) {

            return $q->whereHas('roles', function ($qu) use ($roleId) {

                return $qu->where('id', $roleId);

            });
        });

    }// end of scopeWhenRoleId

    public function scopeWhenCountryId($query, $country)
    {
        return $query->when($country, function ($q) use ($country) {

            return $q->where('country_id', $country);

        });

    }// end of scopeWhenCountryId

    public function scopeWhenGovernorateId($query, $governorateId)
    {
        return $query->when($governorateId, function ($q) use ($governorateId) {

            return $q->where('governorate_id', $governorateId);

        });

    }// end of scopeWhenGovernorateId

    public function scopeWhenDegreeId($query, $degreeId)
    {
        return $query->when($degreeId, function ($q) use ($degreeId) {

            return $q->where('degree_id', $degreeId);

        });

    }// end of scopeWhenDegreeId

    public function scopeWhenCenterIdAsTeacher($query, $centerId)
    {
        return $query->when($centerId, function ($q) use ($centerId) {

            return $q->whereHas('teacherCenters', function ($qu) use ($centerId) {

                return $qu->where('id', $centerId);

            });

        });

    }// end of scopeWhenCenterId

    public function scopeWhenStudentCenterId($query, $centerId)
    {
        return $query->when($centerId, function ($q) use ($centerId) {

            return $q->where('student_center_id', $centerId);

        });

    }// end of scopeWhenCenterIdAsStudent

    public function scopeWhenStudentProjectId($query, $projectId)
    {
        return $query->when($projectId, function ($q) use ($projectId) {

            return $q->where('student_project_id', $projectId);

        });

    }// end of scopeWhenStudentProjectId

    public function scopeWhenStudentSectionId($query, $sectionId)
    {
        return $query->when($sectionId, function ($q) use ($sectionId) {

            return $q->where('student_section_id', $sectionId);

        });

    }// end of scopeWhenStudentSectionId

    public function scopeWhenStudentSectionIds($query, $sectionIds)
    {
        return $query->when(is_array($sectionIds), function ($q) use ($sectionIds) {

            return $q->whereIn('student_section_id', $sectionIds);

        });

    }// end of scopeWhenStudentSectionId

    public function scopeWhenGender($query, $gender)
    {
        return $query->when($gender, function ($q) use ($gender) {

            return $q->where('gender', $gender);

        });

    }// end of scopeWhenGender

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {

            return $q->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");

        });

    }// end of scopeWhenSearch

    public function scopeWhenReadingType($query, $readingType)
    {
        return $query->when($readingType, function ($q) use ($readingType) {

            return $q->where('reading_type', $readingType);

        });

    }// end of scopeWhenReadingType

    //rel
    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);

    }// end of gradesForStudent

    public function currentStudentGrade()
    {
        return $this->hasOne(StudentGrade::class)->latestOfMany();

    }// end of currentGradeForStudent

    public function country()
    {
        return $this->belongsTo(Country::class);

    }// end of country

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);

    }// end of governorate

    public function degree()
    {
        return $this->belongsTo(Degree::class);

    }// end of degree

    public function managerCenters()
    {
        return $this->belongsToMany(Center::class, 'center_manager', 'manager_id');

    }// end of center

    public function teacherCenters()
    {
        return $this->belongsToMany(Center::class, 'teacher_center', 'teacher_id');

    }// end of teacherCenters

    public function teacherAndManagerCenters()
    {
        // $managerCenters = $this->managerCenters()->get();
        // $teacherCenters = $this->teacherCenters()->get();
        //
        // return $managerCenters->merge($teacherCenters)->unique('id');

        return $this->belongsToMany(Center::class, 'center_manager', 'manager_id')
            ->select('centers.*')
            ->orWhereIn('centers.id', function ($query) {
                $query->select('center_id')
                    ->from('teacher_center')
                    ->where('teacher_id', $this->id);
            })
            ->groupBy('centers.id');

    }// end of teacherAndManagerCenters

    public function teacherSections()
    {
        return $this->belongsToMany(Section::class, 'teacher_center_section', 'teacher_id')
            ->withPivot('center_id')
            ->using(TeacherCenterSection::class);

    }// end of gradesAsTeacher

    public function studentCenter()
    {
        return $this->belongsTo(Center::class, 'student_center_id');

    }// end of center

    public function studentSection()
    {
        return $this->belongsTo(Section::class, 'student_section_id');

    }// end of studentSection

    public function studentProject()
    {
        return $this->belongsTo(Project::class, 'student_project_id');

    }// end of studentProject

    public function sectionAsStudent()
    {
        return $this->belongsTo(Section::class, 'student_section_id');

    }// end of sectionAsStudent

    public function sectionsAsStudent()
    {
        return $this->hasMany(StudentSection::class, 'student_id');

    }// end of sectionsAsStudent

    public function studentLogs()
    {
        return $this->hasMany(Log::class, 'student_id');

    }// end of studentLogs

    public function teacherLectures()
    {
        return $this->hasMany(Lecture::class, 'teacher_id');

    }// end of teacherLectures

    public function studentLectures()
    {
        return $this->hasMany(StudentLecture::class, 'student_id');

    }// end of studentLectures

    public function teacherStudentLectures()
    {
        return $this->hasMany(StudentLecture::class, 'teacher_id');

    }// end of teacherStudentLectures

    public function studentPages()
    {
        return $this->hasMany(Page::class, 'student_id');

    }// end of studentPages

    public function studentExams()
    {
        return $this->hasMany(StudentExam::class, 'student_id');

    }// end of studentExams

    public function teacherExams()
    {
        return $this->hasMany(StudentExam::class, 'teacher_id');

    }// end of teacherExams

    public function examinerExams()
    {
        return $this->hasMany(StudentExam::class, 'examiner_id');

    }// end of examinerExams

    //fun
    public function isManagerInCenterId($centerId)
    {
        return $this->managerCenters->contains($centerId);

    }// end of isManagerInCenterId

    public function isTeacherInCenterId($centerId)
    {
        return $this->teacherCenters->contains($centerId);

    }// end of isTeacherInCenterId

    public function isTeacherForSectionIdInCenterId($sectionId, $centerId)
    {
        return $this->teacherSections->contains(function ($section) use ($sectionId, $centerId) {

            return $section->id == $sectionId && $section->pivot->center_id == $centerId;

        });

    }// end of isTeacherForGradeIdInCenterId

    public function isCenterManager()
    {
        return $this->managerCenters->isNotEmpty();

    }// end of isCenterManager

    public function isCenterManagerForCenterId($centerId)
    {
        return $this->managerCenters->contains($centerId);

    }// end of isCenterManagerForCenterId

    public function isExaminer()
    {
        return $this->is_examiner;

    }// end of isExaminer

    protected static function booted()
    {
        static::created(function (User $user) {

            $user->name = $user->first_name . ' ' . $user->second_name;
            $user->saveQuietly();

        });

        static::updated(function (User $user) {

            $user->name = $user->first_name . ' ' . $user->second_name;

            // if ($user->isDirty('student_section_id')) {
            //
            //     $user->sectionsAsStudent()->create([
            //         'center_id' => $user->student_center_id,
            //         'section_id' => $user->student_section_id,
            //     ]);
            //
            // }

            $user->saveQuietly();

        });

    }//end of booted

}//end of model
