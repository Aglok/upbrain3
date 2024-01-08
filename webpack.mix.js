"use strict";
let mix = require('laravel-mix');

/*mix
//Пока не трогаем less, так как для admin->bootstrap3, мы обновились до bootstrap4
/!*.less('resources/assets/less/common.less','public/packages/sleepingowl/default/css/admin-app.css')
    .options({
        sourceMap: 'inline',
        use: [
            { loader: 'style-loader', options: { sourceMap: true } },
            { loader: 'css-loader', options: { sourceMap: true } },
            { loader: 'postcss-loader', options: { sourceMap: true } },
            { loader: 'sass-loader', options: { sourceMap: true } }
        ]
    })*!/

.js('resources/assets/js_owl/app.js',           'public/packages/sleepingowl/default/js/admin-app.js')
.js('resources/assets/js_owl/vue_init.js',      'public/packages/sleepingowl/default/js/vue.js')
.js('resources/assets/js_owl/modules_load.js',  'public/packages/sleepingowl/default/js/modules.js')

.copy('resources/assets/fonts',                 'public/packages/sleepingowl/default/fonts')
//.copy('node_modules/bootstrap/fonts',           'public/packages/sleepingowl/default/fonts')
.copy('node_modules/font-awesome/fonts',        'public/packages/sleepingowl/default/fonts').sourceMaps();*/

// mix.setPublicPath('./public/packages/sleepingowl/default/');
// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });
/*mix
    .sass('resources/assets/scss/app.scss',     'css/admin-app.css')
    //.less('resources/assets/less/common.less',     'css/admin-app.css')
    .js('resources/assets/js_owl/vue_init.js',     'js/vue.js'). vue()
    //.js('resources/assets/js_owl/app.js',          'js/admin-app.js').vue()
    .js('resources/assets/js_owl/app-dev.js', 'js/admin-app.js').vue()
    .js('resources/assets/js_owl/modules_load.js', 'js/modules.js').vue()

    .options({
        processCssUrls: true,
        resourceRoot: '../',
        imgLoaderOptions: {
            enabled: false
        },
    }).sourceMaps();*/


//Компиляция для frontend

// const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

mix.sass('resources/assets/home_3/src/styles/index.scss', 'public/home3/css/home-app.css')
    .js('resources/assets/home_3/src/main.js', 'public/home3/js/home-app.js').vue({ version: 2})
    .copy('resources/assets/home_3/public', 'public/home3')
    .options({
        processCssUrls: true,
        resourceRoot: '../',
        imgLoaderOptions: {
            enabled: false
        }
    })
    .sourceMaps();

mix.webpackConfig({
    //plugins: [new VuetifyLoaderPlugin()]
});
