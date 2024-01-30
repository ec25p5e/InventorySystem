<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="{{ asset('/AdminLTE-2/dist/css/AdminLTE.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning">404</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Pagina non trovata.</h3>
                <p>
                    La pagina alla quale stai tentando di accedere non esiste.
                    Torna alla <a href="{{ url('/') }}">pagina principale</a>.
                </p>
            </div>
        </div>
    </section>
</div>
<script src="{{asset('admin-assets/dist/js/adminlte.js')}}"></script>
</body>
</html>
