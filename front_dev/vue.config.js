module.exports = {
    lintOnSave: false,
    runtimeCompiler: true,
    configureWebpack: {
        //Necessary to run npm link https://webpack.js.org/configuration/resolve/#resolve-symlinks
        resolve: {
            symlinks: false
        }
    },
    transpileDependencies: [
        '@coreui/utils'
    ],

    //local
    //publicPath: process.env.NODE_ENV === 'production' ? 'http://192.168.1.3/franco_construction_v2/build/' : '/'

    //live
    publicPath: process.env.NODE_ENV === 'production' ? 'http://192.168.254.199/melford_inventory_v2/build/' : '/'
}
