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
    'resources/admin/lib/fontawesome-free/css/all.css',
    'resources/admin/lib/Ionicons/css/ionicons.css',
    'resources/admin/lib/datatables/css/jquery.dataTables.css',
    'resources/admin/lib/select2/css/select2.min.css',
    'resources/admin/lib/trumbowyg/dist/ui/trumbowyg.css',
    'resources/admin/lib/jt.timepicker/css/jquery.timepicker.css',
    'resources/admin/lib/bootstrap-tagsinput/css/bootstrap-tagsinput.css'
], 'public/css/vendors.css');
mix.sass('resources/admin/sass/app.scss', 'public/css');

mix.scripts([
    'resources/admin/lib/jquery/js/jquery.js',
    'resources/admin/lib/popper.js/js/popper.js',
    'resources/admin/lib/bootstrap/js/bootstrap.js',
    'resources/admin/lib/jquery-ui/js/jquery-ui.js',
    'resources/admin/lib/datatables/js/jquery.dataTables.js',
    'resources/admin/lib/select2/js/select2.min.js',
    'resources/admin/lib/notify/js/notify.min.js',
    'resources/admin/lib/trumbowyg/dist/trumbowyg.js',
    'resources/admin/lib/jt.timepicker/js/jquery.timepicker.js',
    'resources/admin/lib/peity/js/jquery.peity.js',
    'resources/admin/lib/jquery.steps/js/jquery.steps.js',
    'resources/admin/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
    'resources/admin/lib/bootstrap-tagsinput/js/bootstrap-tagsinput.js'
], 'public/js/vendors.js');
mix.js('resources/admin/js/theme.js', 'public/js');
mix.copyDirectory('resources/admin/lib/fontawesome-free/webfonts', 'public/webfonts');
if (mix.inProduction()) {
    mix.version();
}



//mix.browserSync('http://localhost:8000');


