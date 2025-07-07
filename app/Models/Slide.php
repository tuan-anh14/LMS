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
        if ($this->image) {
            return asset('storage/uploads/' . $this->image);
        }
        return asset('images/default.jpg');

    }// end of getImagePathAttribute

    //scope

    //rel

    //fun

}//end of model
