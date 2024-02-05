<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AdminLTE')</title>
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/quagga.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        function loadUnityInformation(product_id, entity, attribute, element, isTable = true) {
            let apiUrl = '/api/loadProductColInfo';

            $.ajax({
                url: apiUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    'product_id': product_id,
                    'entity': entity,
                    'product_attribute': attribute
                },
                success: function (data) {
                    if(isTable) {
                        $(element).append(data['value'])
                    } else {
                        $(element).val(data['value'])
                    }
                },
                error: function (xhr, status, error) {
                    $(element).append(error)
                }
            });
        }
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed skin-blue">
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="" src="{{asset('https://www.sdk-csd.ch/admin/data/files/member/image/64/logo@3x_logo_big.png?lm=1572338395')}}" alt="AdminLTELogo" height="60" width="60">
    </div>


    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="content-wrapper">
        @yield('content-header')

        <section class="content">
            <div class="container-fluid">
                @yield('body')
            </div>
        </section>
    </div>



    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>


    @yield('js')

    <script>
        $(document).ready(function () {
            $.AdminLTE.layout.activate();
            $.AdminLTE.layout.fix();
        });
    </script>

    <script>
        window.addEventListener('load', function load() {
            const loader = document.getElementById('loader');
            setTimeout(function() {
                loader.classList.add('fadeOut');
            }, 50);
        });
    </script>


</div>
</body>
</html>
