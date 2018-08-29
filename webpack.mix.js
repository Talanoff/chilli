let mix = require('laravel-mix');

mix.js('resources/assets/admin/js/app.js', 'public/js/admin.js')
   .sass('resources/assets/admin/sass/app.scss', 'public/css/admin.css');

mix.js('resources/assets/app/js/app.js', 'public/js/app.js')
    .sass('resources/assets/app/sass/app.scss', 'public/css/app.css');
