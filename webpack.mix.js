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

mix.scripts([
    './resources/js/vendor/jquery.js',
    './resources/js/vendor/popper.min.js',
    './resources/js/vendor/bootstrap.js',
    './resources/js/profile.js',
    './resources/js/reglogin.js',
    './resources/js/profile.js',
    './resources/js/admin/index.js',
    './resources/js/admin/user.js',
    './resources/js/admin/access.js',
    './resources/js/admin/role.js',
], 'public/js/app.js')
    .styles([
        './resources/css/vendor/bootstrap.css',
        './resources/css/vendor/font-awesome.min.css',
    ], 'public/css/app.css');
    // .version();
