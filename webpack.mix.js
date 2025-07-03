const mix = require('laravel-mix');

mix
    .js(
        [
            'public/admin_assets/custom/js/shared/theme.js',
            'public/admin_assets/custom/js/shared/index.js',
            'public/admin_assets/custom/js/index.js',
            'public/admin_assets/custom/js/roles.js',
            'public/admin_assets/custom/js/languages.js',
            'public/admin_assets/custom/js/countries.js',
            'public/admin_assets/custom/js/teachers.js',
            'public/admin_assets/custom/js/centers.js',
            'public/admin_assets/custom/js/lectures.js',
            'public/admin_assets/custom/js/sections.js',

        ],
        'public/admin_assets/app.js'
    )
    .styles(
        [
            'public/admin_assets/custom/css/style.css',
        ],
        'public/admin_assets/app.min.css'
    )
    .version();

