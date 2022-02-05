const mix = require("laravel-mix");
mix.disableNotifications();

mix.postCss("resources/css/vendor-admin.css", "public/css/vendor-admin.css");
mix.js("resources/js/inputmask.js", "public/js/inputmask.js");
//mix.js("resources/js/select2.js", "public/js/select2.js");
mix.js("resources/js/cropper.js", "public/js/cropper.js");
mix.sass("resources/sass/vendor.scss", "public/css/vendor.css");
