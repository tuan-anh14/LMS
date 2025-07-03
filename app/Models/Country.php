<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //attr

    //scope

    //rel
    public function teachers()
    {
        return $this->hasMany(User::class)
            ->where('type', UserTypeEnum::TEACHER);

    }// end of teachers

    public function students()
    {
        return $this->hasMany(User::class)
            ->where('type', UserTypeEnum::STUDENT);

    }// end of student

    public function governorates()
    {
        return $this->hasMany(Governorate::class);

    }// end of governorates

    public function areas()
    {
        return $this->hasManyThrough(Area::class, Governorate::class);

    }// end of areas

    //fun

}// end of model
