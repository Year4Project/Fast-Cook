
// import ReactRefresh from '@vitejs/plugin-react';

// export default {
//   plugins: [ReactRefresh()],
//   build: {
//     target: 'esnext',
//     polyfillDynamicImport: false,
//     outDir: 'dist',
//     assetsDir: '.',
//     minify: 'terser',
//     sourcemap: true,
//     rollupOptions: {
//       // Add the following line to specify the jsx loader
//       // for files with the .js extension
//       plugins: [{ name: 'vite-plugin-jsx' }],
//     },
//   },
// };

// vite.config.js

import { defineConfig } from 'vite';

export default defineConfig({
  // Base URL for the project (default is '/')
  base: '/',

  // Output directory for builds (default is 'dist')
  outDir: 'dist',

  // Serve configurations
  server: {
    port: 3000, // Port number
    open: true, // Open browser when server starts
  },

  // Configure plugins
  plugins: [
    // Add plugins here
  ],

  // CSS configurations
  css: {
    // Enable CSS modules
    modules: true,
  },

  // Resolve configurations
  resolve: {
    // Alias configurations
    alias: {
      // Example alias
      '@': '/src',
    },
  },

  // Build configurations
  build: {
    // Minify output (default is 'terser')
    minify: 'terser',
  },
});
