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
        return asset('storage/uploads/' . $this->icon);

    }// end of getIconPathAttribute

    //scope

    //rel

    //fun

}//end of model
