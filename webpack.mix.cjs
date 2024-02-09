let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/var-editor.js', 'public/js')
    .version();

mix.setPublicPath('public')
    .setResourceRoot('http://172.16.8.8:8000');

mix.setResourceRoot('/admin-assets/');


