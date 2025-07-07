<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    //attr
    public function getIconPathAttribute()
    {
        if ($this->icon) {
            return asset('storage/uploads/' . $this->icon);
        }
        return asset('images/default.jpg');

    }// end of getIconPathAttribute

    //scope

    //rel

    //fun

}//end of model
