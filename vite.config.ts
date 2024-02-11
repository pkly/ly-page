import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'

// https://vitejs.dev/config/
export default defineConfig({
  publicDir: false,
  plugins: [
    vue(),
    vueJsx(),
  ],
  build: {
    rollupOptions: {
      input: {
        'main': './vue/main.ts',
      },
      output: {
        dir: './public/vue/',
        entryFilenames: '[name].js',
      }
    }
  }
})
