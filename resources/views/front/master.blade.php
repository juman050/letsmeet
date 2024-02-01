<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('public/front/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('public/front/css/font-awesome.min.css')}}">
        @stack('styles')
        <!-- Select 2 css -->
        <link rel="stylesheet" href="{{url('public/front/select2/dist/css/select2.min.css')}}" />

        <link rel="stylesheet" type="text/css" href="{{url('public/front/css/style.css')}}">
    </head>
    <body>
         <!-- header -->
        @include('front.includes.header')       
        <!-- maincontent -->
        @yield('mainContent')
        <!-- footer -->
        @include('front.includes.footer')

    </body>
</html>
