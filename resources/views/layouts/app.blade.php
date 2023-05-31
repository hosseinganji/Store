<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="theme-color" content="#ffffff">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <script src="{{ asset('jquery.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/jquery.czMore-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@29.1.0/dist/ag-grid-enterprise.min.js"></script>
</head>
<body>
{{-- slidbar --}}
<div class="sidebar sidebar-dark sidebar-fixed d-flex" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('icons/brand.svg#full') }}"></use>
        </svg>
    </div>
    @include('layouts.navigation')

    
</div>

{{-- body --}}
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        @include('layouts.header')
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                
                @yield('content')
                
            </div>
        </div>
            <footer class="footer">
                <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io">Bootstrap Admin Template</a> &copy; 2021
                    creativeLabs.
                </div>
                <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/bootstrap/ui-components/">CoreUI UI
                        Components</a></div>
            </footer>
    </div>


<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<style>
    .pagination{
        justify-content: center;
    }
</style>


@yield('script')


</body>
</html>
