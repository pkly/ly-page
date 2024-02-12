import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import VueDevTools from 'vite-plugin-vue-devtools'

// https://vitejs.dev/config/
export default defineConfig({
  publicDir: false,
  plugins: [
    vue(),
    vueJsx(),
    VueDevTools(),
  ],
  define: {
    __VUE_PROD_DEVTOOLS__: true
  },
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
