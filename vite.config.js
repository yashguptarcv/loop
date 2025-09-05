import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/toast.css', 'resources/css/fontawesome/all.min.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/app.js', 'resources/js/category-selector.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
