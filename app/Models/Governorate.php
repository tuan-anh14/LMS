<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'name'];

    //attr

    //scope
    public function scopeWhenCountryId($query, $countryId)
    {
        return $query->when($countryId, function ($q) use ($countryId) {

            return $q->where('country_id', $countryId);

        });

    }// end of scopeWhenCountryId

    //rel
    public function country()
    {
        return $this->belongsTo(Country::class);

    }// end of country

    public function students()
    {
        return $this->hasMany(User::class)
            ->where('type', UserTypeEnum::STUDENT);

    }// end of students

    public function teachers()
    {
        return $this->hasMany(User::class)
            ->where('type', UserTypeEnum::TEACHER);

    }// end of teachers

    //fun

}//end of model
