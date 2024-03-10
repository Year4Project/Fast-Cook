import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    base: '',
    build: {
        emptyOutDir: true,
        manifest: true,
        outDir: 'build',
        assetsDir: 'assets'
    },
      plugins: [
            laravel({
                  input: [
                        'resources/sass/app.scss',
                        'resources/js/app.js',
                  ],
                  refresh: [
                    '**.php'
                ]
            }),
      ],
      resolve: {
        alias: [
            {
                find: /~(.+)/,
                replacement: process.cwd() + '/node_modules/$1'
            },
        ]
    }
});
