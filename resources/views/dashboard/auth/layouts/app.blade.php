<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRE-aMi84EF0rE7n1UO-NleqVM0-kW5BZzNA&s">
    <title>{{ config('app.name') }} | @yield('title' , '') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800;1,6..12,900;1,6..12,1000&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/icofont.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/themify.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/flag-icon.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/style.css">
    <link id="color" rel="stylesheet" href="https://admin.pixelstrap.com/cion/assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="https://admin.pixelstrap.com/cion/assets/css/responsive.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ route('view-image', ['m' => 'Setting', 'id' => 0, 'nameVar'=> 'logo']) }}">
</head>
  <body>
    @yield('content')

