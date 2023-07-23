<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>
    @stack('css')
</head>
<body class=" min-h-screen bg-gradient-to-b from-indigo-50 to-indigo-200">
    @include('nav.guestNav')
    <div class="container mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        @yield('content')
    </div>
</body>
@stack('scripts')
</html>