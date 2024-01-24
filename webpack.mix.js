const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();

mix.js('resources/js/app.js', 'public/js')
    .version();

mix.setPublicPath('public')
    .setResourceRoot('http://172.16.8.8:8000'); // Assicurati che questo sia correttamente impostato

