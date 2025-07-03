<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'upper_title', 'image', 'link', 'status'];

    //attr
    public function getImagePathAttribute()
    {
        return asset('storage/uploads/' . $this->image);

    }// end of getImagePathAttribute

    //scope

    //rel

    //fun

}//end of model
