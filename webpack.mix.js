const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.styles([
    'resources/plantilla/css/bootstrap.min.css',
//    'resources/plantilla/css/jquery-ui.min.css',
   'resources/plantilla/css/estilo.min.css',
   'resources/plantilla/css/font-awesome.min.css',
//    'resources/plantilla/css/vue-select.css',
    'resources/plantilla/css/animate.css',
   'resources/plantilla/css/hamburgers.min.css',
   'resources/plantilla/css/select2.min.css',
   'resources/plantilla/css/util.css',
   'resources/plantilla/css/main.css',
   'resources/plantilla/css/toastr.min.css',
], 'public/css/all.css');

mix.scripts([
    'resources/plantilla/js/jquery-3.2.1.min.js',
    'resources/plantilla/js/resolucion.js',
    'resources/plantilla/js/application.js',
	'resources/plantilla/js/tether.min.js',
    // 'resources/plantilla/js/jquery.tablesorter.min.js',
    'resources/plantilla/js/bootstrap.min.js',
    // 'resources/plantilla/js/Chart.min.js',
    // 'resources/plantilla/js/graficas.js'
    'resources/plantilla/js/popper.js',
    'resources/plantilla/js/sweetalert2.all.min.js',
    'resources/plantilla/js/select2.min.js',
    'resources/plantilla/js/tilt.jquery.min.js',
    'resources/plantilla/js/toastr.js',
    ], 'public/js/all.js');

mix.js('resources/js/app.js', 'public/js/app.js');
//     .sass('resources/sass/app.scss', 'public/css');
