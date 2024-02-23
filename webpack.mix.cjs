let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/assets/js')
    .js('resources/js/var-editor.js', 'public/assets/js')
    .version();

mix.js('node_modules/jquery/dist/jquery.js', 'public/assets/js')
    .version();

mix.css('resources/css/app.css', 'public/assets/css/app.css')
    .version();

mix.copy('node_modules/deskapp/vendors/fonts', 'public/template/fonts')
    .copy('node_modules/deskapp/vendors/images', 'public/template/images')
    .copy('node_modules/deskapp/vendors/scripts', 'public/template/scripts')
    .copy('node_modules/deskapp/vendors/styles', 'public/template/styles')
    .copy('node_modules/deskapp/src/plugins', 'public/template/plugins')
    .version();

mix.copy('node_modules/intro.js/minified/intro.min.js', 'public/template/scripts')
    .copy('node_modules/intro.js/minified/introjs.min.css', 'public/template/styles')
    .version();

mix.copy('resources/images/*', 'public/assets/images')
    .version();

mix.setPublicPath('public')
    .setResourceRoot('http://172.16.8.8:8000');


