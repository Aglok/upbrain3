let mix = require('laravel-mix');

mix

.less('resources/assets/less/common.less','public/packages/sleepingowl/default/css/admin-app.css')
    .options({
        sourceMap: 'inline',
        use: [
            { loader: 'style-loader', options: { sourceMap: true } },
            { loader: 'css-loader', options: { sourceMap: true } },
            { loader: 'postcss-loader', options: { sourceMap: true } },
            { loader: 'sass-loader', options: { sourceMap: true } }
        ]
    })

.js('resources/assets/js_owl/app.js',           'public/packages/sleepingowl/default/js/admin-app.js')
.js('resources/assets/js_owl/vue_init.js',      'public/packages/sleepingowl/default/js/vue.js')
.js('resources/assets/js_owl/modules_load.js',  'public/packages/sleepingowl/default/js/modules.js')

.copy('resources/assets/fonts',                 'public/packages/sleepingowl/default/fonts')
.copy('node_modules/bootstrap/fonts',           'public/packages/sleepingowl/default/fonts')
.copy('node_modules/font-awesome/fonts',        'public/packages/sleepingowl/default/fonts').sourceMaps();

