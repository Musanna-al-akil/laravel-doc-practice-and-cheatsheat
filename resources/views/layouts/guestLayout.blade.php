<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>
    @stack('css')
</head>
<body class="h-screen bg-gradient-to-b from-gray-100 to-gray-400">
    @include('nav.guestNav')
    <div class="container mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>