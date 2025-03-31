// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';
import playformCompress from '@playform/compress';

import sitemap from '@astrojs/sitemap';

// https://astro.build/config
export default defineConfig({
  site: 'https://wp-astro-test.web',
  vite: {
    plugins: [
      tailwindcss(),
    ]
  },

  server: {
    port: 3000,
    host: true,
  },
  output: 'static',
  integrations: [playformCompress(), sitemap()],
});