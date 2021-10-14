const mix = require('laravel-mix');
mix.disableNotifications();

mix.webpackConfig({
    stats: {
        warnings: false,
    }
});
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

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);

mix.sass('resources/sass/vendor.scss', 'public/css/vendor.css')
mix.postCss('resources/css/site.css', 'public/css/site.css')
mix.js('resources/js/inputmask.js', 'public/js/inputmask.js')