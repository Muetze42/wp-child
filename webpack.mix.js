const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
    .setPublicPath('assets')
    .sass('resources/scss/theme.scss', 'css')
    .sass('resources/scss/elementor-editor.scss', 'css')
    .scripts(['resources/js/theme.js'], 'assets/js/theme.js')
    .scripts(['resources/js/elementor-editor.js'], 'assets/js/elementor-editor.js')
    .version()
    .disableNotifications()
    .sourceMaps()
;
