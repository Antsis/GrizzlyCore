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
    './resources/js/vendor/cropper.js',
    './resources/js/vendor/jquery-cropper.js',

    './resources/js/common.js',
    
    './resources/js/profile/index.js',
    './resources/js/profile/avatar.js',
    './resources/js/profile/account.js',

    './resources/js/admin/index.js',
    './resources/js/admin/user.js',
    './resources/js/admin/access.js',
    './resources/js/admin/role.js',

    './resources/js/user/login.js',
    './resources/js/user/register.js',
    './resources/js/user/index.js',


], 'public/js/app.js')
    .styles([
        './resources/css/vendor/bootstrap.css',
        './resources/css/vendor/font-awesome.min.css',
        './resources/css/vendor/cropper.css',

        './resources/css/profile/avatar.css'
    ], 'public/css/app.css')
    .version();
