<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdvancedController extends Controller
{
    public function collection()
    {
        Collection::macro('IncrementByFive',function(){
            return $this->map(function($item){
                return $item + 5;
            });
        });
        $collect = collect([1,2,3,7,3,6]);
        

        return $collect->IncrementByFive()->chunk(2);
    }
}
