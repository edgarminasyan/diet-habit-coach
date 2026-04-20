import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        laravel({ input: 'resources/js/app.js', refresh: true }),
        vue({ template: { transformAssetUrls: { base: null, includeAbsolute: false } } }),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Diet & Habit Coach',
                short_name: 'Coach',
                description: 'Track meals, habits and progress',
                theme_color: '#4A7259',
                background_color: '#F6F4EF',
                display: 'standalone',
                orientation: 'portrait',
                start_url: '/dashboard',
                icons: [
                    { src: '/icons/icon-192.png', sizes: '192x192', type: 'image/png' },
                    { src: '/icons/icon-512.png', sizes: '512x512', type: 'image/png' },
                ],
            },
            workbox: { navigateFallback: null },
        }),
    ],
    resolve: { alias: { '@': '/resources/js' } },
})
