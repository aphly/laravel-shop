<!DOCTYPE html>
<html style="font-size: 14px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('shop.name')}}</title>
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/c.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/iconfont.css') }}">
    <script src='{{ URL::asset('vendor/laravel-admin/js/jquery.min.js') }}' type='text/javascript'></script>
    <script src="{{ URL::asset('vendor/laravel-admin/js/jquery.lazyload.min.js') }}" type="text/javascript"></script>
    <script src='{{ URL::asset('vendor/laravel-admin/js/c.js') }}' type='text/javascript'></script>
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-admin/css/viewer.min.css') }}">
    <script src="{{ URL::asset('vendor/laravel-admin/js/viewer.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product.css') }}">
</head>
<body>
<style>
    @font-face {
        font-family: "Poppins-Regular";
        src: url("{{ URL::asset('vendor/laravel-shop/font/Poppins-Regular.woff') }}") format('woff');
    }
    body{background: #fafafa;font-family: "Poppins-Regular";}
    .breadcrumb-wrapper{background-color:transparent;line-height:50px;font-size:12px}
    .breadcrumb-wrapper a {color: #4c4c4c;}
</style>
