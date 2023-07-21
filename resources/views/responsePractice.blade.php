<!Doctype html>
<html>
<head>
    <title>request practic</title>
    <!-- 9.2 loading scripts and css-->
    @vite('resources/css/response.css')
</head>
<body>

    <!-- 10.1 generating urls -->
    <p>{{$data['url']}}</p>
    <!-- 10.2 current path -->
    <p>{{$data['currentPath']}}</p>
    <!-- 10.3 current path with route name -->
    <p>{{$data['currentPathWithName']}}</p>
    <!-- 10.4 generate sign url -->
    <p>{{$data['signUrl']}}</p>

    <h1 class="ping">response</h1>
    <!-- 9.7 loading image-->
    <img width=300px height=400px  src="{{ Vite::asset('resources/images/img.jpg')}} ">

    <h1>11.1 Session</h1>
    
    <a href="{{$data['previous']}}"> {{$data['previous']}}</a>

    <p style="color:blue;"> {{Session::get('status')}}</p>
</body>
</html>