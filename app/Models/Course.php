<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'title', 'short_description', 'description', 'image'];

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return asset('storage/uploads/' . $this->image);
        }
        return asset('images/default.jpg');

    }// end of getImagePathAttribute

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}//end of model
