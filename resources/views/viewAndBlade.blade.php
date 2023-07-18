<!Doctype html>
<html>
<head>
    <title>view practice</title>
</head>
<body>
    <!-- 8.1 display data-->
    hello {{$name}} 
    <p>{{$author}}</p>
    <p>{{$count}}</p>
    <p>The current UNIX timestamp is {{ time() }}.</p>
    <p>{{e('<h1>hfdsaf</h>')}}</P>

    <!-- 8.2 unescaped data-->
    <p>{!!  '<h1>dasfa</h1>'!!}</p>

    <!-- 8.3 Blade & JavaScript Frameworks-->
    @{{ name }}

    <!-- 8.4 rendering json-->
    <pre>{{json_encode(['ping'=>['ling'=>'hello','ding'],['bing','jong'=> 'dong']])}}</pre>
    <script>
    var app = {{ Illuminate\Support\Js::from(['ping'=>'ding']) }};
    console.log(app);
    </script> 
    
     <!-- 8.5 @verbatim directive -->
    @verbatim
        <div class="container">
            Hello, {{ name }}.
        </div>
    @endverbatim

    <!-- 8.6 -->
    @unless (Auth::check())
        You are not signed in.
    @endunless

    <br>
    @empty($records)
        // $records is "empty"...
    @endempty

    <br>
    @auth
        // The user is authenticated...
    @endauth
    
    @guest
        // The user is not authenticated...
    @endguest

    <br>printing number 1-4 -> 
    @for($i = 0; $i <5; $i++)
    {{ $i+1 }}
    @endfor

    <p @style(['color:red','font-size:20px'=> true])>this is conditional styling</p>
</body>
</html>