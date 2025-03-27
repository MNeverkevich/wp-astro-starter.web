// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';
import playformCompress from '@playform/compress';

// https://astro.build/config
export default defineConfig({
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
  integrations: [playformCompress()],
});