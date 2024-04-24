
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // Import the @vitejs/plugin-vue plugin
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            transformAssetUrls:{
                base: null,
                includeAbsolute: false
            }
        }),
    ],
    resolve: {
        alias: {
            'ziggy': path.resolve('vendor/tightenco/ziggy/dist/index.esm.js'),
            'fontawesome': path.resolve('node_modules/@fontawesome/fontawesome-free')
        }
    }
});