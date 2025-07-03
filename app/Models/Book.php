<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'number_of_pages', 'image'];

    //attr
    public function getImagePathAttribute()
    {
        return asset('storage/uploads/' . $this->image);

    }// end of getImagePathAttribute

    //scope

    //rel
    public function projects()
    {
        return $this->hasMany(Project::class);

    }// end of projects

    //fun
    public function canBeDeleted()
    {
        return $this->projects->count() == 0;

    }// end of canBeDeleted

}//end of model
