/*
 * |-------------------------------------------------|
 * |          Compilando Arquivos Estáticos          |
 * |                                                 |
 * | Modo de Uso:                                    |
 * |   npm run dev: compila arquivos em modo dev     |
 * |                sem arquivos de terceiros        |
 * |                                                 |
 * |   npm run watch: compila arquivos em modo dev   |
 * |                sem arquivos de terceiros e      |
 * |                fica analisando atualizações     |
 * |                                                 |
 * |   npm run dev-all: compila todos os arquivos    |
 * |                em modo dev, incluindo vendor    |
 * |                                                 |
 * |   npm run prod: compila e minifica arquivos     |
 * |-------------------------------------------------|
 */

const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");
mix.disableNotifications();

mix.webpackConfig({
    stats: {
        warnings: true,
        //children: true
    },
});
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
*/

if (process.env.WITHOUT && process.env.WITHOUT == "vendor") {
    mix
        .postCss("resources/css/style.css", "public/css/")
        .postCss("resources/css/admin.css", "public/css/")
        .js("resources/js/script.js", "public/js")
        .autoload({ jquery: ["$", "window.jQuery", "jQuery"] })
        .js("resources/js/admin.js", "public/js")
        .sass("resources/sass/custom.scss", "public/css/style.css")
        .mergeManifest();

    mix.js("resources/js/vue.js", "public/js/vue.js")
        .vue()
        .mergeManifest()

    mix.js("resources/js/vue-admin.js", "public/js/vue-admin.js")
        .vue()
        .mergeManifest()
} else {
    mix.postCss("resources/css/vendor.css", "public/css/")
        .sass("resources/sass/vendor.scss", "public/css/vendor.css")
        .postCss("resources/css/vendor-admin.css", "public/css/")
        .sass("resources/sass/vendor-admin.scss", "public/css/vendor-admin.css")
        .js("resources/js/vendor.js", "public/js")
        .js("resources/js/vendor-admin.js", "public/js")

        .postCss("resources/css/style.css", "public/css/")
        .postCss("resources/css/admin.css", "public/css/")
        .js("resources/js/script.js", "public/js")
        .autoload({ jquery: ["$", "window.jQuery", "jQuery"] })
        .js("resources/js/admin.js", "public/js")
        .sass("resources/sass/custom.scss", "public/css/style.css")

    mix.js("resources/js/vue.js", "public/js/vue.js").vue()
    mix.js("resources/js/vue-admin.js", "public/js/vue-admin.js").vue()
}

if (mix.inProduction()) {
    mix.version();
}
