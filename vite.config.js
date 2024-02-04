import { defineConfig } from 'vite';
import reactRefresh from '@vitejs/plugin-react-refresh';

export default defineConfig({
  plugins: [reactRefresh()],
  build: {
    target: 'esnext',
    polyfillDynamicImport: false,
    outDir: 'dist',
    assetsDir: '.',
    minify: 'terser',
    sourcemap: true,
    rollupOptions: {
      // Add the following line to specify the jsx loader
      // for files with the .js extension
      plugins: [{ name: 'vite-plugin-jsx' }],
    },
  },
});
