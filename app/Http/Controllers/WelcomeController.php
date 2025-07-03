<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\TruckType;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['redirect_to_dashboard']);

    }// end of __construct

    public function index()
    {
        return view('welcome');

    }// end of index

}//end of controller
