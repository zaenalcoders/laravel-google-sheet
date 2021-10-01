<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title') | VGR Dashboard</title>
    <meta name="title" content="@yield('meta_title') | VGR Dashboard">
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
</head>

<body>
    <div class="container-fluid mt-3">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
