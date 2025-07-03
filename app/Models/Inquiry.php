<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    //attr

    protected $fillable = ['title', 'email', 'message'];

    //scope

    //rel

    //fun

}//end of model
