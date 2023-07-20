<!Doctype html>
<html>
<head>
    <title>request practic</title>
    <!-- 9.2 loading scripts and css-->
    @vite('resources/css/response.css')
</head>
<body>

    <!-- 10.1 generating urls -->
    <p>{{$url}}</p>
    <!-- 10.2 current path -->
    <p>{{$currentPath}}</p>
    <!-- 10.3 current path with route name -->
    <p>{{$currentPathWithName}}</p>
    <!-- 10.4 generate sign url -->
    <p>{{$signUrl}}</p>

    <h1 class="ping">response</h1>

    <!-- 9.7 loading image-->
    <img width=500px height=700px  src="{{ Vite::asset('resources/images/img.jpg')}} ">
</body>
</html>