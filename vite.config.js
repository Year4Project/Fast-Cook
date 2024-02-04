import { defineConfig } from 'vite'; // Import defineConfig from 'vite'

import ReactRefresh from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [ReactRefresh()], // Wrap ReactRefresh in an array
  build: {
    target: 'esnext',
    polyfillDynamicImport: false,
    outDir: 'dist',
    assetsDir: '.',
    minify: 'terser',
    sourcemap: true,
    rollupOptions: {
      // Adjust the plugins array
      plugins: [{ name: 'vite-plugin-jsx' }],
    },
  },
});
