<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keyword" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>小牛儿智慧商店</title>
       <!-- Bootstrap core CSS -->
       
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
     
    <link href="{{asset('css/login.css')}}" rel="stylesheet">
    <script src="{{ asset('js/jquery-1.9.1.js') }}"></script>
</head>

<body>

@yield('content')

</body>
</html>
