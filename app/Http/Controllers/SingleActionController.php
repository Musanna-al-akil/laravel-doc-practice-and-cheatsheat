<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidOrderException;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SingleActionController extends Controller
{
    //2. single action controller
    public function __construct(){
        // 3. constructor middleware
        $this->middleware('throttle:ratelimitbytwo');
        // $this->middleware(function (Request $request, Closure $next) {
        //     if(Route::currentRouteName() == 'hello'){
        //        return redirect('/');
        //     }
        //     return $next($request);
        // });
    }
    public function __invoke(){
        
        throw new InvalidOrderException('This a custom exceiption', 100);
    }
}
