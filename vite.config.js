import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
 
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
        
    ],
    build: {
        outDir: 'public/build', // Menyimpan hasil build di dalam public/build
        manifest: true,        
    },
})