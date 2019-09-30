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

    .copy('resources/img/', 'public/storage/')

    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
    .copy('resources/sass/main.css', 'public/css/main.css')
    .copy('resources/fonts/', 'public/fonts/')

    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
    .copy('resources/js/panzoom.js', 'public/js/panzoom.js')

    .copy('resources/js/shelf-products.json', 'public/shelf-products.json')

    .copy('resources/plugins/tooltipster', 'public/plugins/tooltipster')
    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/bootstrap.bundle.min.js')
    .copy('resources/js/shelfshop.js', 'public/js/shelfshop.js')
    .copy('resources/js/utils.js', 'public/js/utils.js')

    .copy('node_modules/jquery-validation/dist/jquery.validate.min.js', 'public/js/jquery.validate.min.js')

    .copy('resources/plugins/imageareaselect', 'public/plugins/imageareaselect')
    .copy('resources/js/initAdmin.js', 'public/js/initAdmin.js')

    .sass('resources/sass/app.scss', 'public/css');
