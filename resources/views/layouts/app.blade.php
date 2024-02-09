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
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/quagga.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/dist/js/adminlte.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.24.0/min/vs/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/editor/editor.main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="{{ asset('admin-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

    <style>@yield('css')</style>
    @yield('start_js')

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

        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-input");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableTargetSearch");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="hold-transition sidebar-mini skin-blue">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.24.0/min/vs/loader.js"></script>

    @yield('js')

    <script>
        $(document).ready(function () {
            const loader = document.getElementById('loader');
            setTimeout(function() {
                loader.classList.add('fadeOut');
            }, 50);
        });
    </script>
</div>
</body>
</html>
