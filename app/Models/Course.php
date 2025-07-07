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
        if ($this->image) {
            return asset('storage/uploads/' . $this->image);
        }
        return asset('images/default.jpg');

    }// end of getImagePathAttribute

}//end of model
