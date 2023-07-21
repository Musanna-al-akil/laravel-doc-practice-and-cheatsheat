<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\URL;
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
        echo $singleInput . '<br>'
        ;

        //5.12 get single query value
        $singleQuery= $request->query('name');
        echo $singleQuery . '<br>';

        return response("dasdf")->header(
                'X-Header-One', 'Header Value',
            );
    }

    public function responsePractice(Request $request){
        /*6.1.2 response object
        return response('hello', 200);
        */

        // 10.1 generating urls
        $url = url('/post/1');
        // 10.2 generating urls
        // $currentPath = url()->previous();
        $currentPath = url()->full();

        // 10.3 generating urls with named route
        $currentPathWithName = route('userName',['name'=>'musanna','id'=>5,'ping'=>'pong']);
        //https://example.com/user/musanna/id/5/?ping=pong

        //10.4 generate sign url
        //signUrl = Url::signedRoute('signUrl',['name'=>'musanna','id'=>5,'ping'=>'pong']);
        $signUrl = URL::temporarySignedRoute('signUrl',now()->addMinutes(10),['name'=>'musanna','id'=>5,'ping'=>'pong']);

        //11.6 store session
        session(['ranName'=>['ping'=>'1']]);
        if($request->session()->exists('ranName')){
            $ran= rand(1,100);
            $request->session()->push('ranName', (string)$ran );

            
        }
        
        //11.4 retrive all session data
        $session = $request->session()->all();

        //11.5 checked a key is present
        if ($request->session()->has('_previous')) {
            //11.3. Retrieving Data
            $previous = $request->session()->get('_previous');
          
        }
        // 11.7 flash data
        $request->session()->flash('status', 'this is flash data');

        //11.9regerate session id
        //$request->session()->regenerate();
        $data = [
            'url'           => $url,
            'currentPath'   => $currentPath,
            'currentPathWithName' =>$currentPathWithName,
            'signUrl'       => $signUrl,
            'previous'       =>$previous['url'],
        ];

        //6.2 header && 6.4 cookie 
        return response()->view('/responsePractice', ['data' => $data])->header('X-Header','value')->cookie('cookieTest','cookie',10);

        /* 6.6 redirect && 6.10 session
        return redirect('/')->with('msg','errors');

        6.6 back previous url
        return back()->withInput();
        */

    }

    public function viewAndBlade(){

        //7.1 create view & pass data & verify if it exits
        //View::make('viewPractice',[$varName=> $varValue]);
        if(View::exists('viewAndBlade')){
            return view('viewAndBlade',['name'=>'musanna']);
        }
    }
}