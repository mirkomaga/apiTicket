<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class UserController extends Controller
{
    public function __constructor(){

    }

    public function getUser(){
        $result = App\User::all();
        return $result;
    }
}
