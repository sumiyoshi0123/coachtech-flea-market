const mix = require('laravel-mix');
const path = require('path');
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

mix.js('resources/js/coachtech-flea-market/src/main.js', 'public/js')
    .vue()
    .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'node_modules'),
        ],
    }
})
