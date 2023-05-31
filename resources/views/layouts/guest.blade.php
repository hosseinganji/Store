<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#ffffff">
    @vite('resources/sass/app.scss')

    <style>
        .admin-panel-header{
            margin-bottom: 0 !important;
            min-height: 10vh;
        }
    </style>
</head>
<body>
    @include('layouts.header')
<div class="bg-light d-flex flex-row align-items-center" style="min-height: 90vh">
    
    <div class="container">
        
        <div class="row justify-content-center">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
</body>
</html>
