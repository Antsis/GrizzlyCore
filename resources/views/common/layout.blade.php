<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta HTTP-EQUIV="pragma" CONTENT="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('meta')

    @show
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>@yield('title', 'Laravel-demo')</title>
</head>
<body>
    <!-- nav -->
    @section('nav')
        @include('common.nav')

    @show
    


    <!-- mainText -->
    @section('maintext')
    
    @show
    

    <!-- footer -->
    @section('footer')
        @include('common.footer')
    @show
    <script src="{{ mix('js/app.js') }}"></script>
    @section('js')

    @show
</body>
</html>