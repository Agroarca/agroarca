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
mix.disableNotifications();

mix.webpackConfig({
    stats: {
        warnings: false,
    },
});

if(!process.env.WITHOUT || process.env.WITHOUT != "vendor"){
    require(`${__dirname}/webpack.vendor.mix.js`);
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [require("postcss-import"), require("autoprefixer")]
);

mix.postCss("resources/css/style.css", "public/css/style.css");
mix.postCss("resources/css/site.css", "public/css/site.css");
mix.js("resources/js/site.js", "public/js");
