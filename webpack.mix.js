const mix = require('laravel-mix');

mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/bootstrap.bundle.min.js');
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css');
mix.copy('node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js', 'public/js/ckeditor.js');

// Compile JavaScript and CSS
mix.js('resources/js/app.js', 'public/js')
    .css('resources/css/app.css', 'public/css')
    .css('resources/css/navbar.css', 'public/css')
    .sourceMaps();
