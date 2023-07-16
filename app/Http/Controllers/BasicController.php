<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\View;

class BasicController extends Controller
{
    public function routeWithMethod()
    {
        return 'This route is created with method';
    }

    //5.1 accessing request
    public function requestPractice(Request $request)
    {
        //5.2 current path info
        $path = $request->path();
        echo $path . '<br>';

        //5.4 current full url info
        $fullUrl= $request->url();
        $fullUrl2= $request->fullUrl();
        echo $fullUrl. '<br>';

        //full path with query
        $fullUrlQuery = $request->fullUrlWithQuery(['ping'=>'pong']);
        echo $fullUrlQuery . '<br>';

        //5.5 retriving host
        $host = $request->host();
        $hostWithPort= $request->httpHost();
        $hostWithPortAndProtocal = $request->schemeAndHttpHost();
        echo $host . ' - ' . $hostWithPort . ' - ' .$hostWithPortAndProtocal .'<br>';

        //5.6 retriving method
        $method = $request->method();
        echo $method . '<br>';

        //5.7 retriving headers
        $header = $request->header('X-Header-One');
        echo $header ."<br>";

        //5.8 ip
        $ip = $request->ip();
        echo $ip."<br>";
        //5.9  Content Negotiation
        $contentTypes = $request->getAcceptableContentTypes();
      
        if ($request->accepts(['text/html', 'application/json'])) {
            echo "dingdong". "<br>";
        }

        //5.10 all input data
        $allData= $request->all();
        $allCollectData= $request->collect();
        
        //5.11 get single input value
        $singleInput= $request->input('name');
        echo $singleInput . '<br>';

        //5.12 get single query value
        $singleQuery= $request->query('name');
        echo $singleQuery . '<br>';

        return response("dasdf")->header(
                'X-Header-One', 'Header Value',
            );
    }
}
