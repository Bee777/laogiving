//initialize customize webpack
var path = require('path');
var entries = {
    'general': path.resolve(__dirname, 'vue', 'starter', 'general.js'),
    'admin': path.resolve(__dirname, 'vue', 'starter', 'admin.js'),
    'volunteer': path.resolve(__dirname, 'vue', 'starter', 'volunteer.js'),
    'organize': path.resolve(__dirname, 'vue', 'starter', 'organize.js'),
};
var type = null;
var devSeverPort = {
    'general': 9000,
    'admin': 9001,
    'volunteer': 9002,
    'organize': 9003,
};
var htmlIndexes = {
    'general': '../public/bundles/index/general.html',
    'admin': '../public/bundles/index/admin.html',
    'volunteer': '../public/bundles/index/volunteer.html',
    'organize': '../public/bundles/index/organize.html',
};
process.noDeprecation = true;
type = process.argv[process.argv.length - 1].replace('--', '');
//initialize customize webpack
module.exports = {
    chainWebpack: config => {
        config
            .plugin("html")
            .tap(args => {
                if (process.env.NODE_ENV) {
                    args[0].template = htmlIndexes[type];
                }
                return args
            })
    },
    configureWebpack: config => {
        config.resolve.alias = {
            'vue$': 'vue/dist/vue.runtime.esm.js',
            '@cus-com': path.resolve(__dirname, 'vue/customize-components'),
            '@com': path.resolve(__dirname, 'vue/components'),
            '@store': path.resolve(__dirname, 'vue/stores'),
            '@route': path.resolve(__dirname, 'vue/routes'),
            '@vue': path.resolve(__dirname, 'vue'),
            '@bases': path.resolve(__dirname, 'vue', 'components', 'Bases'),
        };
        config.entry = {app: entries[type]};

        if (process.env.NODE_ENV === 'production') {
            config.output.filename = '[contenthash:8].bundle.js';
            config.output.chunkFilename = 'chunks/[id].[chunkhash].js';
        } else {

        }
    },
    devServer: {
        port: devSeverPort[type],
        contentBase: '../public/',
        historyApiFallback: true,
        noInfo: true,
        host: 'localhost',
        clientLogLevel: 'info'
    },
    indexPath: path.resolve('..', 'public', 'bundles', type),
    outputDir: path.resolve('..', 'public', 'bundles', type),
    publicPath: process.env.NODE_ENV === 'production' ? "{{url('/bundles')}}/" + type : '/',
};
