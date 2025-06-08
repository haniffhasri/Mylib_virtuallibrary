import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
    preprocessorOptions: {
      scss: {
        additionalData: '', // optional global SCSS variables
        includePaths: ['node_modules'], // <== tell Sass to look inside node_modules
      },
    },
  },
});
