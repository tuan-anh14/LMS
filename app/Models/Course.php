<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'short_description', 'description', 'image',];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/' . $this->image);

    }// end of getImagePathAttribute

}//end of model
