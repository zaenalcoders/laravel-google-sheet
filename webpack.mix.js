const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').sourceMaps()
    .sass('resources/css/app.scss', 'public/css')
    .styles(['public/css/app.css',
        'resources/css/preloader.min.css',
        'resources/css/icons.min.css',
        'resources/css/app.min.css'],
        'public/css/app.css');
