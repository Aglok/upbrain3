// let path = require('path');
//
// module.exports = {
//     entry: './resources/assets/js/app.js',
//
//     output: {
//         path: path.resolve(__dirname, 'public/js/vue'),
//         filename: 'app.js',
//         publicPath: "public"
//     },
//     module: {
//         loaders: [
//         {
//             test: /\.vue$/,
//             loader : 'vue-loader',
//             exclude: /(node_modules)/
//
//          },
//         {
//             test: /\.js$/,
//             loader: 'babel-loader',
//             exclude: /node_modules/
//         },
//         {
//             test: /\.scss$/,
//             use: ['style-loader', 'css-loader', 'sass-loader']
//         }
//         ]
//     }
// };

let path = require('path');
let webpack = require('webpack');

new webpack.ProvidePlugin({
    PRODUCTION: JSON.stringify(true),
    'Admin': './resources/assets/js/owl/js/components/admin.js',
    $: "jquery",
    jQuery: "jquery",
    'window.jQuery': 'jquery',
    'window.$': 'jquery',
    Vue: ['vue/dist/vue.esm.js', 'default']
    //'window.Admin': './resources/assets/js/owl/js/components/admin.js',
    // $: 'jquery',
    // 'window.jQuery': 'jquery'
});

module.exports = {
    entry: {
        'admin-app': './resources/assets/js/owl/js/app.js',
        'vue': './resources/assets/js/owl/js/vue_init.js',
        'modules': './resources/assets/js/owl/js/modules_load.js',
    },
    output: {
        path: path.resolve(__dirname, 'public/js/owl'),
        filename: '[name].js',
        publicPath: "public"
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.common.js'
        }
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader : 'vue-loader',
                exclude: /(node_modules)/

            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.scss$/,
                use: ['style-loader', 'css-loader', 'sass-loader']
            }
        ],
    }
};