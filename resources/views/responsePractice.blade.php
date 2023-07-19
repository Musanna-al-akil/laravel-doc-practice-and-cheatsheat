<!Doctype html>
<html>
<head>
    <title>request practic</title>
    <!-- 9.2 loading scripts and css-->
    @vite('resources/css/response.css')
</head>
<body>


    <h1 class="ping">response</h1>

    <!-- 9.7 loading image-->
    <img width=500px height=700px  src="{{ Vite::asset('resources/images/img.jpg')}} ">
</body>
</html>