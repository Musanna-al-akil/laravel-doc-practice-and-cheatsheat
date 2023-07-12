<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BasicController extends Controller
{
    public function routeWithMethod(){
        return 'This route is created with method';
    }
}
