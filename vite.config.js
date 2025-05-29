import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',       // Escucha en todas las interfaces
        port: 5173,            // El puerto por defecto
        strictPort: true,
        hmr: {
            host: '192.168.1.18', // Ej: '192.168.1.34'
        },
    },
});
