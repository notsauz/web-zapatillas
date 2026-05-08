import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/layouts.css',
                'resources/css/sneakers.index.css',
                'resources/css/profile.edit.css',
                "resources/css/filter-summary.css",
                'resources/js/app.js',
                'resources/js/catalog-lazy-load.js',
                'resources/js/catalog-favorites.js',
                'resources/js/sneaker-recently-viewed.js',
                'resources/js/filters-toggle.js',
                'resources/js/admin/layout.js',
                'resources/js/admin/brands-form.js',
                'resources/js/admin/sneakers-form.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
