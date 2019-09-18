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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/front-side.scss', 'public/css/front-side.css')
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
    .copy('node_modules/jquery-tooltipster/css/tooltipster.css', 'public/css/tooltipster.css')

    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
    .copy('resources/js/panzoom.js', 'public/js/panzoom.js')

    .copy('node_modules/jquery-tooltipster/js/jquery.tooltipster.js', 'public/css/tooltipster.js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
    .copy('resources/js/selfshop.js', 'public/js/selfshop.js')
    .copy('resources/js/utils.js', 'public/js/utils.js')
    .sass('resources/sass/app.scss', 'public/css');
