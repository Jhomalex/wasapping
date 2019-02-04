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
mix.scripts([
   'resources/plantilla/js/popper.js',
   'resources/plantilla/js/jquery-3.3.1.js',
   'resources/plantilla/js/materialize.js',
   'resources/plantilla/js/general.js',
   'resources/plantilla/js/dropzone.js',
], 'public/js/plantilla.js')
   .styles([
   'resources/plantilla/css/materialize.css',
   'resources/plantilla/css/general.css',
   'resources/plantilla/css/dropzone.css',
], 'public/css/plantilla.css')
   .js([
   'resources/js/app.js'
], 'public/js/app.js');
