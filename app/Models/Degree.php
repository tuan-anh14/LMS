<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
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

    //fun
    public function canBeDeleted()
    {
        return $this->teachers->count() == 0;

    }// end of canBeDeleted

}//end of model
