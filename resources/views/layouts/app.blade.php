<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <title>@yield('title', 'AdminLTE')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/icon-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/style.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('template/plugins/datatables/css/dataTables.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('template/plugins/datatables/css/responsive.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('template/styles/icon-font.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}"/>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>

    @livewireStyles

    <style>@yield('css')</style>
</head>
<body>
<!-- <div class="pre-loader">
    <div class="pre-loader-box">
        <div class="loader-logo">
            <img src="" alt="" />
        </div>
        <div class="loader-progress" id="progress_div">
            <div class="bar" id="bar1"></div>
        </div>
        <div class="percent" id="percent1">0%</div>
        <div class="loading-text">Loading...</div>
    </div>
</div> -->

@include('partials.navbar')
@include('partials.right-sidebar')
@include('partials.left-sidebar')

<div class="main-container">
    @yield('body')
</div>

<script src="{{ asset('template/scripts/core.js') }} "></script>
<script src="{{ asset('template/scripts/script.js') }} "></script>
<script src="{{ asset('template/scripts/process.js') }} "></script>
<script src="{{ asset('template/scripts/layout-settings.js') }} "></script>
<script src="{{ asset('template/plugins/wysihtml5-master/dist/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('template/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('template/scripts/datatable-setting.js') }}"></script>

@livewireScripts

@yield('js')
</body>
</html>
