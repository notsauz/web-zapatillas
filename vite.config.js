import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/sneakers.index.css',
                'resources/js/app.js',
                'resources/js/catalog-lazy-load.js',
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
