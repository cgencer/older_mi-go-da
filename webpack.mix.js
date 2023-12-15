const mix = require('laravel-mix');
var LiveReloadPlugin = require('webpack-livereload-plugin');
mix.disableNotifications();

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
mix.disableNotifications();
mix.version();

mix.scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/jquery-mousewheel/jquery.mousewheel.js',
        'node_modules/jquery-bridget/jquery.bridget.js',
        'node_modules/enquire/dist/enquire.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        'node_modules/bootstrap-slider/dist/bootstrap-slider.js',
        'node_modules/select2/dist/js/select2.full.js',
        'node_modules/air-datepicker/dist/js/datepicker.js',
        'node_modules/air-datepicker/dist/js/i18n/datepicker.nl.js',
        'node_modules/air-datepicker/dist/js/i18n/datepicker.de.js',
        'node_modules/air-datepicker/dist/js/i18n/datepicker.en.js',
        'node_modules/air-datepicker/dist/js/i18n/datepicker.fr.js',
        'node_modules/lightgallery/dist/js/lightgallery.js',
        'node_modules/lg-autoplay/dist/lg-autoplay.js',
        'node_modules/lg-fullscreen/dist/lg-fullscreen.js',
        'node_modules/lg-hash/dist/lg-hash.js',
        'node_modules/lg-pager/dist/lg-pager.js',
        'node_modules/lg-share/dist/lg-share.js',
        'node_modules/lg-thumbnail/dist/lg-thumbnail.js',
        'node_modules/lg-video/dist/lg-video.js',
        'node_modules/lg-zoom/dist/lg-zoom.js',
        'node_modules/pusher-js/dist/web/pusher.js',
        'node_modules/laravel-echo/dist/echo.iife.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'node_modules/intl-tel-input/build/js/utils.js'
    ],
    'public/front/assets/js/vendor-scripts.js');

mix.scripts([
        'resources/scripts/coupons.js',
        'resources/scripts/intlTelInput.js',
        'resources/scripts/menu.js',
        'resources/scripts/misc.js',
        'resources/scripts/reservations.js',
        'resources/scripts/slider.js'
    ],
    'public/front/assets/js/migoda-scripts.js')
    .sourceMaps();

mix.js('resources/scripts/pusher-echo.js', 'public/front/assets/js/migoda-notifications.js');

mix.sass('resources/styles/old/app.scss', 'public/front/assets/css/oldstyles_bundled.css')
    .sass('resources/styles/app.scss', 'public/front/assets/css/migoda-styles.css')
    .sass('public/admin/assets/scss/app.scss', 'public/admin/assets/css/app.css')
    .options({
        processCssUrls: false,
        postCss: [
            require('postcss-discard-comments')({
                removeAll: true
            }),
            require('autoprefixer')
        ],
    })
    .webpackConfig({
        devtool: 'source-map',
        plugins: [new LiveReloadPlugin()]
    }).version();

