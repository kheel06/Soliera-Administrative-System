import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/soliera.css',
                'resources/css/sidebar-collapse.css',
                'resources/css/icon-standardization.css',
                'resources/js/app.js',
                'resources/js/notification-websocket.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        target: 'es2022',
        manifest: 'manifest.json',
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    server: {
        host: 'localhost',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    }
});