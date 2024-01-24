mix.js('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.copy('node_modules/admin-lte/dist/css/adminlte.min.css', 'public/css/adminlte.min.css');
mix.copy('node_modules/admin-lte/dist/js/adminlte.min.js', 'public/js/adminlte.min.js');

