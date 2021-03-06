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
    .js('resources/js/bundles/redoc.standalone.js', 'public/js/redoc.standalone.js')
    .sass('resources/sass/mystyle.scss', 'public/css/mystyle.css')
    .sass('resources/sass/rules.scss', 'public/css/rules.css');
