var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .createSharedEntry('vendor', ['jquery', 'bootstrap-sass', 'bootstrap-sass/assets/stylesheets/_bootstrap.scss'])
    .addStyleEntry('style', './assets/scss/style.scss')
    .addEntry('main', './assets/js/main.js')
    .autoProvidejQuery()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning();

module.exports = Encore.getWebpackConfig();